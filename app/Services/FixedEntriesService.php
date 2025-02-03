<?php

namespace App\Services;

use App\Helper\AddSalaryEmployee;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FixedEntriesService
{
    public static function store(Request $request, $id,$monthNow)
    {
        // Update Fixed Entries In Static Month
        $fixedEntriesStatic = FixedEntries::updateOrCreate([
            'employee_id' => $id,
            'month' => '0000-00',
            ],[
            'administrative_allowance' => $request['administrative_allowance-0000'] != null || $request['administrative_allowance-0000'] != "" ? $request['administrative_allowance-0000'] : -01,
            'scientific_qualification_allowance' => $request['scientific_qualification_allowance-0000'] != null || $request['scientific_qualification_allowance-0000'] != "" ? $request['scientific_qualification_allowance-0000'] : -01,
            'transport' =>  $request['transport-0000'] != null || $request['transport-0000'] != "" ? $request['transport-0000'] : -01,
            'extra_allowance' =>  $request['extra_allowance-0000'] != null || $request['extra_allowance-0000'] != "" ? $request['extra_allowance-0000'] : -01,
            'salary_allowance' =>  $request['salary_allowance-0000'] != null || $request['salary_allowance-0000'] != "" ? $request['salary_allowance-0000'] : -01,
            'ex_addition' => $request['ex_addition-0000'] != null || $request['ex_addition-0000'] != "" ? $request['ex_addition-0000'] : -01,
            'mobile_allowance' => $request['mobile_allowance-0000'] != null || $request['mobile_allowance-0000'] != "" ? $request['mobile_allowance-0000'] : -01,
            'health_insurance' => $request['health_insurance-0000'] != null || $request['health_insurance-0000'] != "" ? $request['health_insurance-0000'] : -01,
            'f_Oredo' =>  $request['f_Oredo-0000'] != null || $request['f_Oredo-0000'] != "" ? $request['f_Oredo-0000'] : -01,
            'tuition_fees' => $request['tuition_fees-0000'] != null || $request['tuition_fees-0000'] != "" ? $request['tuition_fees-0000'] : -01,
            'voluntary_contributions' => $request['voluntary_contributions-0000'] != null || $request['voluntary_contributions-0000'] != "" ? $request['voluntary_contributions-0000'] : -01,
            'paradise_discount' => $request['paradise_discount-0000'] != null || $request['paradise_discount-0000'] != "" ? $request['paradise_discount-0000'] : -01,
            'other_discounts' => $request['other_discounts-0000'] != null || $request['other_discounts-0000'] != "" ? $request['other_discounts-0000'] : -01,
            'proportion_voluntary' => $request['proportion_voluntary-0000'] != null || $request['proportion_voluntary-0000'] != "" ? $request['proportion_voluntary-0000'] : -01,
            'savings_rate' => $request['savings_rate-0000'] == "on" ? 1 : -01,
        ]);

        // Update Fixed Entries In Months of The Year
        $year = $request->header('year');
        $month_last = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');
        for($i=1; $i <= 12; $i++) {
            $monthlast = Carbon::parse($month_last)->format('m');
            $i = $i < 10 ? '0'.$i : $i;
            if($monthlast != 12){
                if($i <= $monthlast){
                    continue;
                }
            }
            $month = $year.'-'.$i;
            $fixedEntriesOld = FixedEntries::where('employee_id', $id)->where('month', $month)->first();
            $fixedEntries = FixedEntries::updateOrCreate([
                'employee_id' => $id,
                'month' => $month
                ],[
                'administrative_allowance' => $request['administrative_allowance-'.$i] ?? 0,
                'scientific_qualification_allowance' => $request['scientific_qualification_allowance-'.$i] ?? 0,
                'transport' =>  $request['transport-'.$i] ?? 0,
                'extra_allowance' =>  $request['extra_allowance-'.$i] ?? 0,
                'salary_allowance' =>  $request['salary_allowance-'.$i] ?? 0,
                'ex_addition' => $request['ex_addition-'.$i] ?? 0,
                'mobile_allowance' => $request['mobile_allowance-'.$i] ?? 0,
                'health_insurance' => $request['health_insurance-'.$i] ?? 0,
                'f_Oredo' =>  $request['f_Oredo-'.$i] ?? 0,
                'tuition_fees' => $request['tuition_fees-'.$i] ?? 0,
                'voluntary_contributions' => $request['voluntary_contributions-'.$i] ?? 0,
                'paradise_discount' => $request['paradise_discount-'.$i] ?? 0,
                'other_discounts' => $request['other_discounts-'.$i] ?? 0,
                'proportion_voluntary' => $request['proportion_voluntary-'.$i] ?? 0,
                'savings_rate' => $request['savings_rate-'.$i] == "on" ? 1 : 0,
            ]);
        }


        // Download Salary
        $employee = Employee::findOrFail($id);
        $salary = Salary::where('employee_id',$id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee,$monthNow);
        }
    }
}
