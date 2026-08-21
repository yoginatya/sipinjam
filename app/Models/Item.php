<?php

namespace App\Models;

use App\Models\Category;
use App\Models\LoanDetail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'category_id',
    'code',
    'name',
    'description',
    'stock',
    'available_stock',
    'condition',
    'image',
    'status'
])]
class Item extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }
}