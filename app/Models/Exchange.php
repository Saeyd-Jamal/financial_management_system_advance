<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'receivables_discount',
        'receivables_addition',
        'savings_discount',
        'savings_addition',
        'reward',
        'exchange_date',
        'exchange_type',
        'association_loan',
        'savings_loan',
        'shekel_loan',
        'notes',
        'username'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
