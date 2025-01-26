<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Exchange;
use App\Models\ReceivablesLoans;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getField($employee,$year,$month,$field){
        $val = $employee->salaries->where('month',$year . '-' . $month)->first() ? $employee->salaries->where('month',$year . '-' . $month)->first()[$field] : 0;
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
                $employee->month1 = $this->getField($employee,$year,'01','late_receivables');
                $employee->month2 = $this->getField($employee,$year,'02','late_receivables');
                $employee->month3 = $this->getField($employee,$year,'03','late_receivables');
                $employee->month4 = $this->getField($employee,$year,'04','late_receivables');
                $employee->month5 = $this->getField($employee,$year,'05','late_receivables');
                $employee->month6 = $this->getField($employee,$year,'06','late_receivables');
                $employee->month7 = $this->getField($employee,$year,'07','late_receivables');
                $employee->month8 = $this->getField($employee,$year,'08','late_receivables');
                $employee->month9 = $this->getField($employee,$year,'09','late_receivables');
                $employee->month10 = $this->getField($employee,$year,'10','late_receivables');
                $employee->month11 = $this->getField($employee,$year,'11','late_receivables');
                $employee->month12 = $this->getField($employee,$year,'12','late_receivables');
                $employee->total_receivables = $employee->totals->total_receivables ?? 0;
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
        $exchanges = Exchange::whereIn('exchange_type',['receivables_discount','receivables_addition'])->get();
        return view('dashboard.pages.receivables',compact('exchanges','year'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $total_receivables = $request->total_receivables;
        $total = ReceivablesLoans::where('employee_id',$id)->first();
        if($total){
            $total->update([
                'total_receivables' => $total_receivables
            ]);
        }else{
            ReceivablesLoans::create([
                'employee_id' => $id,
                'total_receivables' => $total_receivables
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
        $pdf = PDF::loadView('dashboard.reports.employee.employee_receivables',['employee' => $employee,'year' => $year],[],
        [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 12,
            'default_font' => 'Arial',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => $margin_top ,
            'margin_bottom' => 0,
        ]);
        $time = Carbon::now();
        return $pdf->stream('تقرير مستحقات للموظف : ' . $employee->name .'  _ '.$time.'.pdf');
    }
}
