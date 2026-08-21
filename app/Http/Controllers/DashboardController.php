<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $base = Loan::where('user_id', $user->id);

        $totalLoans = (clone $base)->count();
        $borrowedLoans = (clone $base)->whereIn('status', ['approved', 'borrowed'])->count();
        $pendingLoans = (clone $base)->where('status', 'pending')->count();

        $recentLoans = Loan::with('details.item.category')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'user',
            'totalLoans',
            'borrowedLoans',
            'pendingLoans',
            'recentLoans'
        ));
    }
}
