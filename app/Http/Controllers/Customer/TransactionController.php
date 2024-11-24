<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

//Library
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
            ]);

            if ($validated['title'] == 'Buy') {
                $product = Product::find($validated['product_id']);
                if ($product->stock < $validated['quantity']) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Stock is not enough'
                    ]);
                }
            }

            $bonus_point = 0;
            if ($validated['title'] == 'Sell') {
                $product = Product::find($validated['product_id']);
                if ($validated['unit'] == 'kg') {
                    // If unit is kilogram
                    $bonus_point = $product->point_per_weight * ($validated['quantity'] * 1000);
                } else {
                    // If unit is gram
                    $bonus_point = $product->point_per_weight * $validated['quantity'];
                }
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
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction added successfully',
                'data' => $transaction
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
                'message' => 'Failed to add transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
}

