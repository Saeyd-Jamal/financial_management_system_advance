<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivablesLoans extends Model
{
    use HasFactory;

    protected $table = 'totals';

    protected $fillable = [
        'employee_id',
        'total_receivables',
        'total_savings',
        'total_association_loan',
        'total_savings_loan',
        'total_shekel_loan',
    ];


    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}

