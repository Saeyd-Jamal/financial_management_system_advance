<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'association_loan',
        'savings_loan',
        'shekel_loan',
    ];


    // Relationship
    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
