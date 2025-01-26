<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkData extends Model
{
    use HasFactory;
    protected $table = 'work_data';

    protected $fillable = [
        'employee_id',
        'working_status',
        'type_appointment',
        'field_action',
        'percentage_allowance',
        'dual_function',
        'years_service',
        'nature_work',
        'state_effectiveness',
        'association',
        'workplace',
        'section',
        'dependence',
        'working_date',
        'date_installation',
        'date_retirement',
        'establishment',
        'foundation_E',
        'allowance',
        'grade',
        'grade_allowance_ratio',
        'salary_category',
        'payroll_statement',
        'installation_new',
        'contract_type',
        'number_working_days',
        'files'
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
