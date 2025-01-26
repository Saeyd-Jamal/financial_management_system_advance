<?php

namespace App\Helper;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ReceivablesLoans;
use App\Models\WorkData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class  AddEmployeeEmpty
{
    public function __construct()
    {

    }

    public static function Add()
    {

        // $name = '';
        // $employee_id = '';
        // $total_savings = 0;

        // $workplace = 'حيفا';
        // $association = 'حيفا';


        $name = 'فداء ناصر محمد بلال';
        $employee_id = 400729364        ;
        $total_savings = 25.07        ;

        $workplace = 'حيفا';
        $association = 'حيفا';

        DB::beginTransaction();
        try {
            $employee = Employee::create([
                'name' => $name,
                'username' => null,
                'password' => null,
                'employee_id' => $employee_id,
                'date_of_birth' => "1991-01-01",
                'age' => 29,
                'gender' => 'ذكر',
                'matrimonial_status' => '',
                'number_wives' => 0,
                'number_children' => 0,
                'number_university_children' => 0,
                'scientific_qualification' => '',
                'specialization' => '',
                'university' => '',
                'area' => '',
                'address' => '',
                'email' => '',
                'phone_number' => '',
            ]);

            WorkData::create([
                'employee_id' => $employee->id,
                'working_status' => '',
                'type_appointment' => '',
                'field_action' => '',
                'percentage_allowance' => 0,
                'dual_function' => '',
                'years_service' => 0,
                'nature_work' => '',
                'state_effectiveness' => 'وقف',
                'association' => $association,
                'workplace' => $workplace,
                'section' => '',
                'dependence' => '',
                'working_date' => '2017-01-01',
                'date_installation' => null,
                'date_retirement' => '2030-01-01',
                'establishment' => '',
                'foundation_E' => '',
                'allowance' => null,
                'grade' => null,
                'grade_allowance_ratio' => null,
                'salary_category' => '',
                'payroll_statement' => '',
                'installation_new' => '',
                'contract_type' => '',
                'number_working_days' => '',
            ]);

            ReceivablesLoans::create([
                'employee_id' => $employee->id,
                'total_receivables' => 0,
                'total_savings' => $total_savings,
                'total_association_loan' => 0,
                'total_savings_loan' => 0,
                'total_shekel_loan' => 0,
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
