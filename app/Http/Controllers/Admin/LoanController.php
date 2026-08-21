<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user', 'details.item')
            ->latest()
            ->paginate(15);

        return view('admin.loans', compact('loans'));
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        DB::transaction(function () use ($loan) {
            $loan->load('details.item');

            foreach ($loan->details as $detail) {
                $item = $detail->item()->lockForUpdate()->first();

                if ($detail->quantity > $item->available_stock) {
                    abort(422, "Stok {$item->name} tidak mencukupi.");
                }

                $item->decrement('available_stock', $detail->quantity);
                $item->update([
                    'status' => $item->available_stock > 0 ? 'available' : 'unavailable',
                ]);
            }

            $loan->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        });

        return back()->with('success', __('messages.loan_approved'));
    }

    public function reject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        $loan->update(['status' => 'rejected']);

        return back()->with('success', __('messages.loan_rejected'));
    }

    public function borrow(Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->with('error', __('messages.loan_must_approved'));
        }

        $loan->update(['status' => 'borrowed']);

        return back()->with('success', 'Barang ditandai sudah diserahkan.');
    }

    public function returnLoan(Loan $loan)
    {
        if ($loan->status !== 'borrowed') {
            return back()->with('error', 'Peminjaman belum berstatus dipinjam.');
        }

        DB::transaction(function () use ($loan) {
            $loan->load('details.item');

            foreach ($loan->details as $detail) {
                $item = $detail->item()->lockForUpdate()->first();
                $item->increment('available_stock', $detail->quantity);
                $item->update(['status' => 'available']);
            }

            $loan->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);
        });

        return back()->with('success', __('messages.loan_returned'));
    }
}
