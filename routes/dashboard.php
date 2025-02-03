<?php


// dashboard routes

use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\AccreditationController;
use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\BankController;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\ExchangeController;
use App\Http\Controllers\Dashboard\FixedEntriesController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\LoanController;
use App\Http\Controllers\Dashboard\ReceivableController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SalaryController;
use App\Http\Controllers\Dashboard\SalaryScaleController;
use App\Http\Controllers\Dashboard\SavingController;
use App\Http\Controllers\Dashboard\SpecificSalaryController;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\Exchange;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '',
    'middleware' => ['auth'],
    'as' => 'dashboard.'
], function () {
    /* ********************************************************** */ 

    // Dashboard ************************
    Route::get('/', [HomeController::class,'index'])->name('home');

    // Logs ************************
    Route::get('logs',[ActivityLogController::class,'index'])->name('logs.index');
    Route::get('getLogs',[ActivityLogController::class,'getLogs'])->name('logs.getLogs');

    // users ************************
    Route::get('profile/settings',[UserController::class,'settings'])->name('profile.settings');

    // reports ************************
    Route::get('report', [ReportController::class,'index'])->name('report.index');
    Route::post('report/export', [ReportController::class,'export'])->name('report.export');

    /* ********************************************************** */ 
    
    // Employees ************************
    Route::get('employees/getEmployee',[EmployeeController::class,'getEmployee'])->name('employees.getEmployee');
    Route::post('employees/uplodeFiles',[EmployeeController::class,'uplodeFiles'])->name('employees.uplodeFiles');
    Route::delete('employees/files_destroy',[EmployeeController::class,'files_destroy'])->name('employees.files_destroy');
    Route::get('employees/getSalary',[EmployeeController::class,'getSalary'])->name('employees.getSalary');
    
    // Totals ************************

        // Receivables ************************
    Route::get('receivables/index',[ReceivableController::class,'index'])->name('receivables.index');
    Route::put('receivables/{receivable}/update',[ReceivableController::class,'update'])->name('receivables.update');
    Route::post('receivables/{receivable}/print',[ReceivableController::class,'print'])->name('receivables.print');

        // Savings ************************
    Route::get('savings/index',[SavingController::class,'index'])->name('savings.index');
    Route::put('savings/{saving}/update',[SavingController::class,'update'])->name('savings.update');
    Route::post('savings/{saving}/print',[SavingController::class,'print'])->name('savings.print');

        // Loans ************************
    Route::post('loans/{loan}/print',[LoanController::class,'print'])->name('loans.print');
    Route::post('loans/getData',[LoanController::class,'getData'])->name('loans.getData');
    Route::get('loans/resetLoans',[LoanController::class,'resetLoans'])->name('loans.resetLoans');

    // Fixed Entries ************************
    Route::post('fixed_entries/getData',[FixedEntriesController::class,'getData'])->name('fixed_entries.getData');


    // Exchanges ************************
    Route::get('exchanges/chooseMany',[ExchangeController::class,'chooseMany'])->name('exchanges.chooseMany');
    Route::post('exchanges/many',[ExchangeController::class,'many'])->name('exchanges.many');
    Route::get('exchanges/getMany',[ExchangeController::class,'getMany'])->name('exchanges.getMany');
    Route::post('exchanges/manyStore',[ExchangeController::class,'manyStore'])->name('exchanges.manyStore');
    Route::post('exchanges/getTotals',[ExchangeController::class,'getTotals'])->name('exchanges.getTotals');
    Route::post('exchanges/{exchange}/print',[ExchangeController::class,'printPdf'])->name('exchanges.print');
    Route::get('exchanges/{exchange}/goToprint', function ($exchange) {
        // استدعاء الدالة مباشرة
        $controller = app(ExchangeController::class);
        return $controller->printPdf(app(\Illuminate\Http\Request::class), $exchange);
    })->name('exchanges.goToprint');
    Route::get('exchanges/{exchange}/goToDestroy', function ($exchange) {
        // استدعاء الدالة مباشرة
        $exchange = Exchange::find($exchange);
        $controller = app(ExchangeController::class);
        return $controller->destroy($exchange);
    })->name('exchanges.goToDestroy');


    // Specific_Salaries ************************

    Route::get('/specific_salaries/index', [SpecificSalaryController::class,'index'])->name('specific_salaries.index');

        // النسبة ************************
    Route::get('/specific_salaries_ratio', [SpecificSalaryController::class,'ratio'])->name('specific_salaries.ratio');
    Route::post('/specific_salaries/ratioCreate', [SpecificSalaryController::class,'ratioCreate'])->name('specific_salaries.ratioCreate');
    Route::post('/specific_salaries/getRatio', [SpecificSalaryController::class,'getRatio'])->name('specific_salaries.getRatio');

        // خاص ************************
    Route::post('/specific_salaries/privateCreate', [SpecificSalaryController::class,'privateCreate'])->name('specific_salaries.privateCreate');

        // رياض ************************
    Route::post('/specific_salaries/riyadhCreate', [SpecificSalaryController::class,'riyadhCreate'])->name('specific_salaries.riyadhCreate');

        // فصلي ************************
    Route::post('/specific_salaries/fasleCreate', [SpecificSalaryController::class,'fasleCreate'])->name('specific_salaries.fasleCreate');

        // المؤقت ************************
    Route::post('/specific_salaries/interimCreate', [SpecificSalaryController::class,'interimCreate'])->name('specific_salaries.interimCreate');

        // اليومي ************************
    Route::post('/specific_salaries/dailyCreate', [SpecificSalaryController::class,'dailyCreate'])->name('specific_salaries.dailyCreate');


    // Salaries ************************
    Route::post('salaries/{id}/view_pdf', [SalaryController::class,'viewPDF'])->name('salaries.view_pdf');
    Route::get('salaries/{salary}/goToPrint', function ($salary) {
        // استدعاء الدالة مباشرة
        $controller = app(SalaryController::class);
        return $controller->viewPDF(app(\Illuminate\Http\Request::class),$salary);
    })->name('salaries.goToPrint');

    Route::post('salaries/getSalariesMonth', [SalaryController::class,'getSalariesMonth'])->name('salaries.getSalariesMonth');
    Route::post('salaries/createAllSalaries', [SalaryController::class,'createAllSalaries'])->name('salaries.createAllSalaries');
    Route::post('salaries/deleteAllSalaries', [SalaryController::class,'deleteAllSalaries'])->name('salaries.deleteAllSalaries');



    /* ********************************************************** */

    // Resources

    Route::resource('constants', ConstantController::class)->only(['index','store','destroy']);
    Route::resource('currencies', CurrencyController::class)->except(['show','edit','create']);
    Route::resource('salary_scales', SalaryScaleController::class)->except(['show','edit','create']);
    Route::resource('banks', BankController::class)->except(['show','create']);
    Route::resource('accounts', AccountController::class)->except(['show','create']);
    Route::resource('loans', LoanController::class)->except(['show','create','destroy']);
    Route::resource('fixed_entries', FixedEntriesController::class)->except(['show','create','destroy']);
    Route::resource('salaries', SalaryController::class)->except(['show','create','store']);
    Route::resource('accreditations', AccreditationController::class)->except(['show','create']);


    Route::resources([
        'users' => UserController::class,
        'employees' => EmployeeController::class,
        'exchanges' => ExchangeController::class,
    ]);
    /* ********************************************************** */ 
});