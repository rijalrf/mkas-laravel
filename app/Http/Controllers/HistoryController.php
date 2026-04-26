<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Transaction::with(['category', 'user'])->latest();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->paginate(20);
        $categories = Category::all();

        if ($request->ajax()) {
            return view('history.partials.list', compact('transactions'));
        }

        return view('history.index', compact('transactions', 'categories'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['category', 'user']);
        return view('history.show', compact('transaction'));
    }

    public function myTransactions()
    {
        return redirect()->route('history.index', ['user_id' => Auth::id()]);
    }
}
