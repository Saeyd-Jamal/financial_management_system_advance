<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Account;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Bank::class);

        $banks = Bank::get();

        return view('dashboard.pages.banks', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Bank::class);

        Bank::create($request->all());

        return redirect()->route('dashboard.banks.index')->with('success', 'تم إضافة بنك جديد');
    }


    public function edit(Bank $bank)
    {
        $this->authorize('update', Bank::class);

        $request = request();
        if($request->ajax()){
            return response()->json($bank);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->authorize('update', Bank::class);

        $bank = Bank::findOrFail($request->id);
        $bank->update($request->all());
        ActivityLogService::log(
            'Updated',
            'Bank',
            "تم تعديل بنك : {$bank->name}.",
            $bank->getOriginal(),
            $bank->getChanges()
        );
        return redirect()->route('dashboard.banks.index')->with('success', 'تم تعديل بيانات البنك');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Bank $bank)
    {
        $this->authorize('delete', Bank::class);

        $bank->delete();

        if($request->ajax()){
            return response()->json(['message' => 'تم حذف البنك']);
        }
        return redirect()->route('dashboard.banks.index')->with('success', 'تم حذف البنك');
    }
}
