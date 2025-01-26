<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AnnualTransfer;
use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccreditationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try{
            $request->merge([
                'user_id' => Auth::user()->id,
                'status' => 1,
            ]);
            if(Carbon::parse($request->month)->format('m') == 12){
                $employees = Employee::with('workData')->whereHas('workData', function ($query) {
                    $query->where('type_appointment', 'مثبت');
                })->get();
                foreach($employees as $employee){
                    AnnualTransfer::transfer($employee);
                    AnnualTransfer::transferBasic($employee);
                }
            }
            Accreditation::create($request->all());
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
            // return redirect()->back()->with('danger', 'حدث خطأ ما');
        }
        return redirect()->back()->with('success', 'تم إعتماد الشهر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accreditation $accreditation)
    {
        DB::beginTransaction();
        try{
            $month = Carbon::parse($accreditation->month)->format('Y-m');
            if(Carbon::parse($month)->format('m') == 12){
                $employees = Employee::with('workData')->whereHas('workData', function ($query) {
                    $query->where('type_appointment', 'مثبت');
                })->get();
                foreach($employees as $employee){
                    AnnualTransfer::transferReverse($employee);
                }
            }
            $accreditation->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
            // return redirect()->back()->with('danger', 'حدث خطأ ما');
        }
        return redirect()->back()->with('danger', 'تم حذف إعتماد الشهر بنجاح');
    }
}
