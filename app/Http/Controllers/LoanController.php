<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('details.item.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function create(Item $item)
    {
        abort_if(
            $item->status !== 'available' || $item->available_stock < 1,
            404
        );

        $item->load('category');

        return view('loans.create', compact('item'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'borrow_date' => ['required', 'date', 'after_or_equal:today'],
            'return_date' => ['required', 'date', 'after_or_equal:borrow_date'],
            'purpose' => ['required', 'string', 'max:1000'],
        ]);

        $item = Item::whereKey($data['item_id'])
            ->lockForUpdate()
            ->firstOrFail();

        if (
            $item->status !== 'available' ||
            $data['quantity'] > $item->available_stock
        ) {
            return back()
                ->withInput()
                ->with('error', 'Stok barang tidak mencukupi.');
        }

        DB::transaction(function () use ($data, $item) {
            $loan = Loan::create([
                'user_id' => Auth::id(),
                'loan_code' => 'PJ-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                'borrow_date' => $data['borrow_date'],
                'return_date' => $data['return_date'],
                'purpose' => $data['purpose'],
                'status' => 'pending',
            ]);

            $loan->details()->create([
                'item_id' => $item->id,
                'quantity' => $data['quantity'],
                'condition_before' => $item->condition,
            ]);
        });

        return redirect()
            ->route('loans.index')
            ->with('success', __('messages.loan_created'));
    }

    public function show(Loan $loan)
    {
        abort_if($loan->user_id !== Auth::id(), 403);

        $loan->load('details.item.category');

        return view('loans.show', compact('loan'));
    }
}
