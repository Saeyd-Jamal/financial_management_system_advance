<?php

namespace App\Services;

use App\Helper\AddSalaryEmployee;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanService
{
    public static function store(Request $request, $id,$monthNow)
    {
        $year = $request->header('year');
        $month_last = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');

        // Edit Total Loans
        $total = ReceivablesLoans::where('employee_id', $id)->first();
        if($total){
            $total->update([
                'total_association_loan' =>  $request['association_loan_total'] ?? 0,
                'total_savings_loan' => $request['savings_loan_total'] ?? 0,
                'total_shekel_loan' => $request['shekel_loan_total'] ?? 0,
            ]);
        }else{
            ReceivablesLoans::create([
                'employee_id' => $id,
                'total_association_loan' =>  $request['association_loan_total'] ?? 0,
                'total_savings_loan' => $request['savings_loan_total'] ?? 0,
                'total_shekel_loan' => $request['shekel_loan_total'] ?? 0,
            ]);
        }

        // Update Loans In Months of The Year
        for ($i=1; $i <= 12; $i++) {
            $monthlast = Carbon::parse($month_last)->format('m');
            $i = $i < 10 ? '0'.$i : $i;
            if($monthlast != 12){
                if($i <= $monthlast){
                    continue;
                }
            }
            $month = $year.'-'.$i;
            $loansOld = Loan::where('employee_id', $id)->where('month', $month)->first();
            $loans = Loan::updateOrCreate([
                'employee_id' => $id,
                'month' => $month
            ],[
                'savings_loan' =>  $request['savings_loan-'.$i] ?? 0,
                'association_loan' => $request['association_loan-'.$i] ?? 0,
                'shekel_loan' => $request['shekel_loan-'.$i] ?? 0,
            ]);
        }

        // Update Loans In Static Month
        Loan::updateOrCreate([
            'employee_id' => $id,
            'month' => '0000-00'
        ],[
            'savings_loan' =>  $request['savings_loan-0000'] != '' || $request['savings_loan-0000'] != null ? $request['savings_loan-0000'] : -01,
            'association_loan' =>  $request['association_loan-0000'] != '' || $request['association_loan-0000'] != null ? $request['association_loan-0000'] : -01,
            'shekel_loan' =>  $request['shekel_loan-0000'] != '' || $request['shekel_loan-0000'] != null ? $request['shekel_loan-0000'] : -01,
        ]);

        
        // Download Salary
        $employee = Employee::findOrFail($id);
        $salary = Salary::where('employee_id',$id)->where('month',$monthNow)->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee,$monthNow);
        }
    }
}
