<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Exchange;
use App\Models\ReceivablesLoans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getField($employee,$year,$month){
        // $val = $employee->salaries->where('month',$year . '-' . $month)->first() ? $employee->salaries->where('month',$year . '-' . $month)->first()[$field] : 0;
        $val = 0;
        if($employee->salaries->where('month',$year . '-' . $month)->first()) {
            // ($savings_loan + (($savings_rate + $termination_service) / $USD ))
            $savings_loan = $employee->salaries->where('month',$year . '-' . $month)->first()->savings_loan ?? 0;
            $savings_rate = $employee->salaries->where('month',$year . '-' . $month)->first()->savings_rate ?? 0;
            $termination_service = $employee->salaries->where('month',$year . '-' . $month)->first()->termination_service ?? 0;
            $USD = Currency::where('name','USD')->first()->value ?? 1;

            $val = $savings_loan + (($savings_rate + $termination_service) / $USD);
        }

        return $val;
    }
    public function index()
    {
        $this->authorize('view', ReceivablesLoans::class);
        $request = request();
        $year = $request->year ?? Carbon::now()->year;
        if($request->ajax()) {
            $employees = Employee::with(['totals','salaries'])->get()->map(function ($employee) use ($year) {
                $employee->name = isset($employee->name)  ? preg_replace('/"(.*?)"/', '($1)', $employee->name)  : '';                
                $employee->association = $employee->workData->association ?? '';
                $employee->month1 = $this->getField($employee,$year,'01');
                $employee->month2 = $this->getField($employee,$year,'02');
                $employee->month3 = $this->getField($employee,$year,'03');
                $employee->month4 = $this->getField($employee,$year,'04');
                $employee->month5 = $this->getField($employee,$year,'05');
                $employee->month6 = $this->getField($employee,$year,'06');
                $employee->month7 = $this->getField($employee,$year,'07');
                $employee->month8 = $this->getField($employee,$year,'08');
                $employee->month9 = $this->getField($employee,$year,'09');
                $employee->month10 = $this->getField($employee,$year,'10');
                $employee->month11 = $this->getField($employee,$year,'11');
                $employee->month12 = $this->getField($employee,$year,'12');
                $employee->total_savings = $employee->totals->total_savings ?? 0;
                return $employee;
            });
            return DataTables::of($employees)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('edit', function ($employee) {
                        return $employee->id;
                    })
                    ->addColumn('print', function ($employee) {
                        return $employee->id;
                    })
                    ->make(true);
        }
        $exchanges = Exchange::whereIn('exchange_type',['savings_discount','savings_addition'])->get();
        return view('dashboard.pages.savings',compact('exchanges','year'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $total_savings = $request->total_savings;
        $total = ReceivablesLoans::where('employee_id',$id)->first();
        if($total){
            $total->update([
                'total_savings' => $total_savings
            ]);
        }
        if($request->ajax()){
            return response()->json(['success' => 'تم تحديث البيانات بنجاح']);
        }
    }

    public function print(Request $request,$id){
        $year = $request->year ?? Carbon::now()->year;
        $employee = Employee::with(['totals','salaries'])->find($id);
        $margin_top = 30;
        if($employee->workData->association == 'صلاح' || $employee->workData->association == 'حطين'){
            $margin_top = 45;
        }
        $pdf = PDF::loadView('dashboard.reports.employee.employee_savings',['employee' => $employee,'year' => $year],[],
        [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 12,
            'default_font' => 'Arial',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => $margin_top,
            'margin_bottom' => 0,
        ]);
        $time = Carbon::now();
        return $pdf->stream('تقرير الإدخارات للموظف : ' . $employee->name .'  _ '.$time.'.pdf');
    }
}
