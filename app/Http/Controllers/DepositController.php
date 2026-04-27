<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Deposit::with('user')->latest();
        
        // If not admin, only show APPROVED deposits by default (Transparency)
        if ($user->role !== 'admin' && !$request->filled('user_id')) {
            $query->where('status', 'APPROVED');
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $deposits = $query->paginate(20);
        $users = \App\Models\User::all();
        
        if ($request->ajax()) {
            return view('deposits.partials.list', compact('deposits'));
        }

        return view('deposits.index', compact('deposits', 'users'));
    }

    public function show(Deposit $deposit)
    {
        $deposit->load('user');
        return view('deposits.show', compact('deposit'));
    }

    public function create()
    {
        $account = PaymentAccount::latest()->first();
        $currentMonth = date('Y-m');
        $existingDeposit = Deposit::where('user_id', Auth::id())
            ->where('month', $currentMonth)
            ->first();

        return view('deposits.create', compact('account', 'existingDeposit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'amount' => 'required|numeric',
        ]);

        // Double check to prevent concurrent submissions
        $exists = Deposit::where('user_id', Auth::id())
            ->where('month', $request->month)
            ->exists();

        if ($exists) {
            return redirect()->route('dashboard')->with('error', 'Iuran untuk bulan ini sudah diajukan!');
        }

        Deposit::create([
            'user_id' => Auth::id(),
            'month' => $request->month,
            'amount' => $request->amount,
            'status' => 'PENDING',
            'description' => 'Iuran Bulan ' . $request->month,
        ]);

        return redirect()->route('dashboard')->with('success', 'Iuran berhasil diajukan! Silakan tunggu konfirmasi admin.');
    }
}
