<?php

namespace App\Http\Controllers;

use App\Models\PaymentPlan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentPlanController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $plans = PaymentPlan::with('category')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->latest()
            ->get();

        $activePlans = $plans->whereIn('status', ['NEW', 'PENDING', 'REJECTED']);
        $paidPlans = $plans->where('status', 'APPROVED');

        $totalAmount = $plans->sum('amount');
        $categories = Category::all();

        return view('payment-plans.index', compact('activePlans', 'paidPlans', 'totalAmount', 'categories', 'currentMonth', 'currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        PaymentPlan::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => 'NEW',
        ]);

        return redirect()->route('payment-plans.index')->with('success', 'Rencana pembayaran berhasil ditambahkan');
    }
}
