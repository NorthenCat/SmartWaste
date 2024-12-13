<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

//Library
use App\Models\Customer;
use App\Models\CustomerPromo;
use App\Models\Transactions;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

//Models
use App\Models\CustomerAddress;
use App\Models\Product;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexBuy()
    {
        $title = 'Buy';
        $products = Product::all();
        return view('customers.transactions.index', compact('title', 'products'));
    }

    public function indexSell()
    {
        $title = 'Sell';
        $products = Product::all();
        return view('customers.transactions.index', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($title, $uuid)
    {
        if ($title == 'Buy') {
            $title = 'Buy';
        } else {
            $title = 'Sell';
        }
        $product = Product::where('uuid', $uuid)->first();
        return view('customers.transactions.form', compact('title', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Memulai transaksi database
        DB::beginTransaction();
        try {
            // Validasi data yang masuk
            $validated = $request->validate([
                'title' => 'required|string|max:255',        // Tipe transaksi (Beli/Jual)
                'product_id' => 'required|integer',          // ID produk
                'product_name' => 'required|string|max:255', // Nama produk
                'quantity' => 'required|min:0.1',            // Jumlah barang
                'unit' => 'required|string|max:255',         // Satuan (kg/g)
                'destination' => 'required|string|max:255',   // Alamat pengiriman
                'price' => 'required',                       // Harga total
                'customer_promo_id' => 'nullable',           // ID promo (opsional)
            ]);

            // Cek keberadaan produk
            $product = Product::find($validated['product_id']);
            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => 'Produk tidak ditemukan'
                ]);
            }

            // Validasi dan penerapan promo
            $isPromo = false;
            if ($validated['customer_promo_id'] != 'null') {
                // Cek apakah promo milik pengguna dan masih valid
                $customerPromo = CustomerPromo::where('id', $validated['customer_promo_id'])
                    ->where('customer_id', Auth::user()->customer->id)
                    ->first();

                if (!$customerPromo) {
                    throw ValidationException::withMessages([
                        'customer_promo_id' => 'Promo tidak ditemukan'
                    ]);
                }

                if ($customerPromo->valid == false) {
                    throw ValidationException::withMessages([
                        'customer_promo_id' => 'Promo sudah tidak berlaku'
                    ]);
                }

                // Tandai promo sudah digunakan
                $isPromo = true;
                $customerPromo->valid = false;
                $customerPromo->save();
            }

            // Proses transaksi BELI
            if ($validated['title'] == 'Buy') {
                // Cek stok produk
                $product = Product::find($validated['product_id']);
                if ($product->stock < $validated['quantity']) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Stok tidak mencukupi'
                    ]);
                }

                // Terapkan diskon jika ada promo
                if ($isPromo) {
                    $validated['price'] = $validated['price'] - ($validated['price'] * ($customerPromo->promo->discount / 100));
                }

                // kurangkan stok produk
                if ($validated['unit'] == $product->stock_unit) {
                    $product->stock -= $validated['quantity'];
                } else if ($validated['unit'] == 'kg' && $product->stock_unit == 'gr') {
                    $product->stock -= ($validated['quantity'] * 1000); // Konversi kg ke gr
                } else if ($validated['unit'] == 'gr' && $product->stock_unit == 'kg') {
                    $product->stock -= $validated['quantity'] / 1000; // Konversi gr ke kg
                }
                $product->save();
            }

            // Proses transaksi JUAL dan perhitungan poin
            $bonus_point = 0;
            if ($validated['title'] == 'Sell') {
                $product = Product::find($validated['product_id']);

                // Hitung poin berdasarkan berat
                if ($validated['unit'] == 'kg') {
                    // Konversi kg ke gram untuk perhitungan poin
                    $bonus_point = ($product->point_per_weight * ($validated['quantity'] * 1000)) / $product->weight_for_point;
                } else {
                    // Langsung hitung dalam gram
                    $bonus_point = ($product->point_per_weight * $validated['quantity']) / $product->weight_for_point;
                }

                // Terapkan pengali poin jika ada promo pengganda poin
                if ($isPromo) {
                    $bonus_point = $bonus_point * $customerPromo->promo->multiply_point;
                }

                // Update poin pelanggan
                $customer = Customer::find(Auth::user()->customer->id);
                $customer->point += $bonus_point;
                $customer->save();

                // tambahkan stok produk
                if ($validated['unit'] == $product->stock_unit) {
                    $product->stock += $validated['quantity'];
                } else if ($validated['unit'] == 'kg' && $product->stock_unit == 'gr') {
                    $product->stock += $validated['quantity'] * 1000; // Konversi kg ke gr
                } else if ($validated['unit'] == 'gr' && $product->stock_unit == 'kg') {
                    $product->stock += $validated['quantity'] / 1000; // Konversi gr ke kg
                }
                $product->save();
            }

            // Buat record transaksi
            $transaction = Transactions::create([
                'uuid' => \Str::uuid(),
                'customer_id' => Auth::user()->customer->id,
                'product_name' => $validated['product_name'],
                'quantity' => $validated['quantity'],
                'unit' => $validated['unit'],
                'total_price' => (double) $validated['price'],
                'address' => $validated['destination'],
                'type' => $validated['title'],
                'bonus_point' => $bonus_point,
                'is_promo' => $isPromo ?? false,
                'promo_id' => $customerPromo->promo->id ?? null,
            ]);

            // Commit transaksi jika semua berhasil
            DB::commit();

            session()->flash('success_transaction', 'Transaksi berhasil ditambahkan');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil ditambahkan',
                'data' => $transaction,
            ], 201);

        } catch (ValidationException $e) {
            // Tangani error validasi
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Tangani error tidak terduga
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addAddress(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'location_name' => 'required|string|max:255',
                'location_address' => 'required|string|max:255',
            ]);

            if (
                CustomerAddress::where('location_name', $validated['location_name'])
                    ->where('customer_id', Auth::user()->customer->id)
                    ->exists()
            ) {
                throw ValidationException::withMessages([
                    'location_name' => 'Address already exists'
                ]);
            }

            $address = CustomerAddress::create([
                'uuid' => \Str::uuid(),
                'customer_id' => Auth::user()->customer->id, // Fixed customer relation
                'location_name' => $validated['location_name'],
                'location_address' => $validated['location_address'],
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Address added successfully',
                'data' => $address
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add address: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addressList()
    {
        $addresses = CustomerAddress::where('customer_id', Auth::user()->customer->id)
            ->get()
            ->map(function ($address) {
                $address->location_name = ucwords(strtolower($address->location_name));
                return $address;
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Address list',
            'data' => $addresses
        ], 200);
    }

    public function promoList($type)
    {
        $customerPromo = CustomerPromo::with('promo')
            ->select(
                'promo_id',
                DB::raw('MAX(id) as id'),
                DB::raw('COUNT(*) as promo_count')
            )
            ->where('customer_id', auth()->user()->customer->id)
            ->where('valid', true)
            ->whereHas('promo', function ($query) use ($type) {
                $query->where('type_transaction', $type);
            })
            ->groupBy('promo_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Promo list',
            'data' => $customerPromo
        ], 200);
    }
}

