<?php

namespace App\Models;

use App\Models\User;
use App\Models\LoanDetail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'loan_code',
    'borrow_date',
    'return_date',
    'purpose',
    'status',
    'approved_at',
    'returned_at'
])]
class Loan extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(LoanDetail::class);
    }
}