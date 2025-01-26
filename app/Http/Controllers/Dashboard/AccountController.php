<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Account;
use App\Models\Employee;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Account::class);

        $accounts = Account::with(['employee','bank'])->orderBy('employee_id', 'asc')->get();
        $employees = Employee::get();
        $banks = Bank::get();

        return view('dashboard.pages.accounts', compact('accounts','employees','banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Account::class);
        $request->validate([
            'employee_id' =>'required|exists:employees,id',
            'bank_id' =>'required|exists:banks,id',
            'account_number' =>'required|max:9',
        ]);
        Account::create($request->all());
        return redirect()->route('dashboard.accounts.index')->with('success', 'تم إضافة حساب بنك جديد');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('update', Account::class);

        $account = Account::with(['employee','bank'])->findOrFail($id);

        if($request->ajax()){
            return $account;
        }
        return view('dashboard.accounts.edit', compact('account','banks','employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->authorize('update', Account::class);
        $request->validate([
            'employee_id' =>'required|exists:employees,id',
            'bank_id' =>'required|exists:banks,id',
            'account_number' =>'required|max:9',
        ]);

        $account = Account::findOrFail($request->id);
        
        $accountOld = $account->getOriginal();

        $account->update($request->all());

        ActivityLogService::log(
            'Updated',
            'Account',
            "تم تحديث حساب بنك : {$account->employee->name}.",
            $accountOld,
            $account->getChanges()
        );
        return redirect()->route('dashboard.accounts.index')->with('success', 'تم تحديث حساب البنك');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete', Account::class);
        
        $account = Account::findOrFail($id);

        $account->delete();
        if($request->ajax()){
            return response()->json(['message' => 'تم حذف حساب البنك']);
        }

        return redirect()->route('dashboard.accounts.index')->with('success', 'تم حذف حساب البنك');
    }
}
