<?php

namespace App\Observers;

use App\Models\Loan;
use App\Services\ActivityLogService;

class LoanObserver
{
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        ActivityLogService::log(
            'Created',
            'Loan',
            "تم إضافة قرض جديد : {$loan->employee->name}.",
            null,
            $loan->toArray()
        );
    }

    /**
     * Handle the Loan "updated" event.
     */
    public function updated(Loan $loan): void
    {
        ActivityLogService::log(
            'Updated',
            'Loan',
            "تم تعديل بيانات قروض للموظف  : {$loan->employee->name}.",
            $loan->getOriginal(),
            $loan->getChanges()
        ); 
    }

    /**
     * Handle the Loan "deleted" event.
     */
    public function deleted(Loan $loan): void
    {
        ActivityLogService::log(
            'Deleted',
            'Loan',
            "تم حذف بيانات قروض للموظف  : {$loan->employee->name}.",
            $loan->toArray(),
            null
        );    
    }

    /**
     * Handle the Loan "restored" event.
     */
    public function restored(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "force deleted" event.
     */
    public function forceDeleted(Loan $loan): void
    {
        //
    }
}
