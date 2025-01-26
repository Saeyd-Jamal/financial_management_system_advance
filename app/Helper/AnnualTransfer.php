<?php

namespace App\Helper;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class  AnnualTransfer
{
    public function __construct()
    {

    }

    public static function transfer($employee)
    {
        $employee = $employee;
        $allowance = $employee->workData->allowance;
        $grade = $employee->workData->grade;
        $salary_category = $employee->workData->salary_category;

        // Salary Category Rank
        $salary_category_rank = [
            2 => [
                'start' => 1,
                'end' => 5
            ],
            3 => [
                'start' => 2,
                'end' => 7
            ],
            4 => [
                'start' => 5,
                'end' => 9
            ],
            5 => [
                'start' => 6,
                'end' => 10
            ]
        ];


        // تعديل علاوة أغراض الراتب الصحة
        if($employee->workData->contract_type == 'صحة' && $employee->workData->type_appointment == 'مثبت'){
            $fixedEntriesStatic = $employee->fixedEntries->where('month','0000-00')->first();
            if($employee->workData->installation_new == 'مثبت جديد'){
                $salary_allowance = $fixedEntriesStatic ? $fixedEntriesStatic->salary_allowance : 0;
                if($salary_allowance > 0){
                    $salary_allowance = ($salary_allowance - 10) < 0 ? 0 : $salary_allowance - 10;
                    $fixedEntriesStatic->update([
                        'salary_allowance' => $salary_allowance,
                    ]);
                }
            }
            if($employee->workData->installation_new == 'مثبت جديد2'){
                $salary_allowance = $fixedEntriesStatic ? $fixedEntriesStatic->salary_allowance : 0;
                if($salary_allowance > 0){
                    $salary_allowance = ($salary_allowance - 20) < 0 ? 0 : $salary_allowance - 20;
                    $fixedEntriesStatic->update([
                        'salary_allowance' => $salary_allowance,
                    ]);
                }
            }
            $employee->workData->update([
                'allowance' => $allowance + 1,
            ]);
        }else{
            // التحويل السنوي للجميع
            // Transfer Logic (Allowance , Grade , Salary Category)
            if($allowance < 4) {
                $employee->workData->update([
                    'allowance' => $allowance + 1,
                ]);
            }else{
                if(in_array($employee->id,[33,57,60])){
                    $employee->workData->update([
                        'allowance' => $allowance + 1,
                    ]);
                    return response()->json('تم التحويل السنوي بنجاح');
                }
                if(in_array($salary_category, [2, 3, 4, 5])){
                    $start = $salary_category_rank[$salary_category]['start'];
                    if($grade > $start){
                        $employee->workData->update([
                            'grade' => $grade - 1,
                            'allowance' => 0,
                        ]);
                        $employee->workData->update([
                            'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio + 5,
                        ]);
                    }
                    if($grade == $start){
                        $employee->workData->update([
                            'allowance' => $allowance + 1,
                        ]);
                    }
                }
                if ($salary_category == 1) {
                    if($grade == 'C'){
                        $employee->workData->update([
                            'grade' => 'B',
                            'allowance' => 0,
                        ]);
                        if ($allowance== 0) {
                            $employee->workData->update([
                                'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio + 5,
                            ]);
                        }
                    }
                    if($grade == 'B'){
                        $employee->workData->update([
                            'grade' => 'A',
                            'allowance' => 0,
                        ]);
                        if ($allowance== 0) {
                            $employee->workData->update([
                                'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio + 5,
                            ]);
                        }
                    }
                    if($grade == 'A'){
                        $employee->workData->update([
                            'allowance' => $allowance + 1,
                        ]);
                    }
                }
            }
        }

        return response()->json('تم التحويل السنوي بنجاح');
    }

    public static function transferBasic($employee){
        $employee = $employee;
        // نقل الأمور السنوية
        $employee->update([
            'age' => $employee->age + 1,
        ]);
        $employee->workData->update([
            'years_service' => $employee->workData->years_service + 1,
        ]);
        return response()->json('تم التحويل السنوي بنجاح');
    }

    public static function transferReverse($employee)
    {
        $employee = $employee;
        $allowance = $employee->workData->allowance;
        $grade = $employee->workData->grade;
        $salary_category = $employee->workData->salary_category;

        // Salary Category Rank
        $salary_category_rank = [
            2 => [
                'start' => 1,
                'end' => 5
            ],
            3 => [
                'start' => 2,
                'end' => 7
            ],
            4 => [
                'start' => 5,
                'end' => 9
            ],
            5 => [
                'start' => 6,
                'end' => 10
            ]
        ];


        // تعديل علاوة أغراض الراتب الصحة
        if($employee->workData->contract_type == 'صحة' && $employee->workData->type_appointment == 'مثبت'){
            $fixedEntriesStatic = $employee->fixedEntries->where('month','0000-00')->first();
            if($employee->workData->installation_new == 'مثبت جديد'){
                $salary_allowance = $fixedEntriesStatic ? $fixedEntriesStatic->salary_allowance : 0;
                if($salary_allowance > 0){
                    $salary_allowance = ($salary_allowance + 10) < 0 ? 0 : $salary_allowance + 10;
                    $fixedEntriesStatic->update([
                        'salary_allowance' => $salary_allowance,
                    ]);
                }
            }
            if($employee->workData->installation_new == 'مثبت جديد2'){
                $salary_allowance = $fixedEntriesStatic ? $fixedEntriesStatic->salary_allowance : 0;
                if($salary_allowance > 0){
                    $salary_allowance = ($salary_allowance + 20) < 0 ? 0 : $salary_allowance + 20;
                    $fixedEntriesStatic->update([
                        'salary_allowance' => $salary_allowance,
                    ]);
                }
            }
            $employee->workData->update([
                'allowance' => $allowance - 1,
            ]);
        }else{
            // التحويل السنوي للجميع
            // Transfer Logic (Allowance , Grade , Salary Category)
            if($allowance < 4) {
                if($allowance == 0){
                    if(in_array($salary_category, [2, 3, 4, 5])){
                        $employee->workData->update([
                            'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio - 5,
                            'allowance' => 4,
                            'grade' => $grade + 1,
                        ]);
                    }else{
                        if($grade == 'C'){
                            $employee->workData->update([
                                'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio - 5,
                                'allowance' => 4,
                                'grade' => 1,
                            ]);
                        }
                        if($grade == 'B'){
                            $employee->workData->update([
                                'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio - 5,
                                'allowance' => 4,
                                'grade' => 'C',
                            ]);
                        }
                        if($grade == 'A'){
                            $employee->workData->update([
                                'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio - 5,
                                'allowance' => 4,
                                'grade' => 'B',
                            ]);
                        }
                    }
                }else{
                    $employee->workData->update([
                        'allowance' => $allowance - 1,
                    ]);
                }
            }else{
                if(in_array($salary_category, [2, 3, 4, 5])){
                    $start = $salary_category_rank[$salary_category]['start'];
                    if($grade > $start){
                        $employee->workData->update([
                            'allowance' => $allowance - 1,
                        ]);
                    }
                    if($grade == $start){
                        $employee->workData->update([
                            'allowance' => $allowance - 1,
                        ]);
                    }
                }
                if ($salary_category == 1) {
                    if($grade == 'C'){
                        $employee->workData->update([
                            'allowance' => $allowance - 1,
                        ]);
                    }
                    if($grade == 'B'){
                        $employee->workData->update([
                            'allowance' => $allowance - 1,
                        ]);
                    }
                    if($grade == 'A'){
                        $employee->workData->update([
                            'allowance' => $allowance - 1,
                        ]);
                    }
                }
            }

            if ((($allowance) % 5 === 0)) {
                $employee->workData->update([
                    'grade_allowance_ratio' => $employee->workData->grade_allowance_ratio - 5,
                ]);
            }

        }

        return response()->json('تم التحويل السنوي بنجاح');
    }
}
