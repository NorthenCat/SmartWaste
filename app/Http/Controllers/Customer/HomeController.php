<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

// Library
use Illuminate\Http\Request;
use DB;

// Models
use App\Models\CustomerPromo;
use App\Models\Promo;
use App\Models\Transactions;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transactions::where("customer_id", auth()->user()->customer->id)
            ->orderBy("created_at", "desc")
            ->get();

        $todayTransactions = $transactions->filter(fn($transaction) => $transaction->created_at->isToday());
        $yesterdayTransactions = $transactions->filter(fn($transaction) => $transaction->created_at->isYesterday());
        $otherTransactions = $transactions->filter(fn($transaction) => !$transaction->created_at->isToday() && !$transaction->created_at->isYesterday())
            ->groupBy(fn($transaction) => $transaction->created_at->format('j F Y'));

        // dd($todayTransactions, $yesterdayTransactions, $otherTransactions);

        return view('customers.home.index', [
            'todayTransactions' => $todayTransactions,
            'yesterdayTransactions' => $yesterdayTransactions,
            'otherTransactions' => $otherTransactions,
        ]);
    }

    public function history()
    {
        $transactions = Transactions::where("customer_id", auth()->user()->customer->id)
            ->orderBy("created_at", "desc")
            ->get();

        $todayTransactions = $transactions->filter(fn($transaction) => $transaction->created_at->isToday());
        $yesterdayTransactions = $transactions->filter(fn($transaction) => $transaction->created_at->isYesterday());
        $otherTransactions = $transactions->filter(fn($transaction) => !$transaction->created_at->isToday() && !$transaction->created_at->isYesterday())
            ->groupBy(fn($transaction) => $transaction->created_at->format('j F Y'));

        return view('customers.history.index', compact('todayTransactions', 'yesterdayTransactions', 'otherTransactions'));
    }

    public function redeemPoint()
    {
        $promos = Promo::all();
        return view('customers.redeemPoint.index', compact('promos'));
    }

    public function buyPromo($uuid)
    {
        try {
            DB::beginTransaction();

            $promo = Promo::where('uuid', $uuid)->first();
            $customer = auth()->user()->customer;

            if (!$promo) {
                throw new \Exception('Promo not found');
            }

            if ($customer->point < $promo->point_price) {
                throw new \Exception('Not enough points');
            }

            $customer->point -= $promo->point_price;
            $customer->save();

            CustomerPromo::create([
                'customer_id' => $customer->id,
                'promo_id' => $promo->id
            ]);

            DB::commit();

            session()->flash('success_redeem', 'Promo purchased successfully');

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
