<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexBuy()
    {
        $title = 'Buy';
        return view('customers.transactions.index', compact('title'));
    }

    public function indexSell()
    {
        $title = 'Sell';
        return view('customers.transactions.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->is('transactions/buy')) {
            $title = 'Buy';
        } else {
            $title = 'Sell';
        }
        return view('customers.transactions.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function map()
    {
        return view('customers.transactions.maps');
    }
}
