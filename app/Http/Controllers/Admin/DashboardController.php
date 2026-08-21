<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalUsers = User::where('role', 'mahasiswa')->count();
        $totalLoans = Loan::count();
        $pendingLoans = Loan::where('status', 'pending')->count();

        $recentLoans = Loan::with('user', 'details.item')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalItems',
            'totalUsers',
            'totalLoans',
            'pendingLoans',
            'recentLoans'
        ));
    }
}
