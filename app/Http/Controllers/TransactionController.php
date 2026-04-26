<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function create(Request $request, $type)
    {
        $categories = Category::all();
        $selectedCategoryId = $request->category_id;
        return view('transactions.create', compact('categories', 'type', 'selectedCategoryId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:IN,OUT',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Validasi Saldo jika Kas Keluar
        if ($request->type === 'OUT') {
            // Hitung saldo global (Admin akses semua, User akses milik bersama?)
            // Berdasarkan App.md, status APPROVED mempengaruhi saldo.
            $totalIn = Transaction::where('status', 'APPROVED')->where('type', 'IN')->sum('amount') + 
                       Deposit::where('status', 'APPROVED')->sum('amount');
            $totalOut = Transaction::where('status', 'APPROVED')->where('type', 'OUT')->sum('amount');
            $currentBalance = $totalIn - $totalOut;

            if ($request->amount > $currentBalance) {
                return back()->with('error', 'Saldo tidak mencukupi!')->withInput();
            }
        }

        $photoPath = $request->file('photo')->store('receipts', 'public');

        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'photo' => $photoPath,
            'user_id' => $user->id,
            'status' => 'PENDING',
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diajukan!');
    }
}
