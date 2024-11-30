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
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'product_id' => 'required|integer',
                'product_name' => 'required|string|max:255',
                'quantity' => 'required|min:0.1',
                'unit' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'price' => 'required',
                'customer_promo_id' => 'nullable',
            ]);

            //check ids
            $product = Product::find($validated['product_id']);
            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => 'Product not found'
                ]);
            }

            if ($validated['customer_promo_id'] != 'null') {
                $customerPromo = CustomerPromo::where('id', $validated['customer_promo_id'])
                    ->where('customer_id', Auth::user()->customer->id)
                    ->first();

                if (!$customerPromo) {
                    throw ValidationException::withMessages([
                        'customer_promo_id' => 'Promo not found'
                    ]);
                }

                if ($customerPromo->valid == false) {
                    throw ValidationException::withMessages([
                        'customer_promo_id' => 'Promo not valid'
                    ]);
                }

                $isPromo = true;
                $customerPromo->valid = false;
                $customerPromo->save();
            }

            if ($validated['title'] == 'Buy') {
                $product = Product::find($validated['product_id']);
                if ($product->stock < $validated['quantity']) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Stock is not enough'
                    ]);
                }

                if ($isPromo) {
                    $validated['price'] = $validated['price'] - ($validated['price'] * ($customerPromo->promo->discount / 100));
                }
            }

            $bonus_point = 0;
            if ($validated['title'] == 'Sell') {
                $product = Product::find($validated['product_id']);
                if ($validated['unit'] == 'kg') {
                    // If unit is kilogram
                    $bonus_point = ($product->point_per_weight * ($validated['quantity'] * 1000)) / $product->weight_for_point;
                } else {
                    // If unit is gram
                    $bonus_point = ($product->point_per_weight * $validated['quantity']) / $product->weight_for_point;
                }

                if ($isPromo) {
                    $bonus_point = $bonus_point * $customerPromo->promo->multiply_point;
                }

                $customer = Customer::find(Auth::user()->customer->id);
                $customer->point += $bonus_point;
                $customer->save();
            }

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

            DB::commit();

            session()->flash('success_transaction', 'Transaction added successfully');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction added successfully',
                'data' => $transaction
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add transaction: ' . $e->getMessage()
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

