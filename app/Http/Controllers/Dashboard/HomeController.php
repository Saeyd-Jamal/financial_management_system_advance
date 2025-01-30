<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\CreateBackup;
use App\Jobs\CreateSalary;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Spatie\Backup\Config\Config;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

class HomeController extends Controller
{
    public function index(){
        $countEmployees = Employee::count();

        $lastAccreditations = Accreditation::latest()->first();
        $monthDownload = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('Y-m') : '2024-07' ;

        $net_salary = Salary::where('month', $monthDownload)->sum('net_salary');

        $workplaces = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        return view('dashboard.index', compact('countEmployees','monthDownload','net_salary','workplaces'));
    }

}

