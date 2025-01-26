<?php

namespace App\Observers;

use App\Models\ReceivablesLoans;
use App\Services\ActivityLogService;

class ReceivablesLoansObserver
{
    /**
     * Handle the ReceivablesLoans "created" event.
     */
    public function created(ReceivablesLoans $receivablesLoans): void
    {
        ActivityLogService::log(
            'Created',
            'ReceivablesLoans',
            "تم إضافة إجماليات للموظف : {$receivablesLoans->employee->name}.",
            null,
            $receivablesLoans->toArray()
        );
    }

    /**
     * Handle the ReceivablesLoans "updated" event.
     */
    public function updated(ReceivablesLoans $receivablesLoans): void
    {
        ActivityLogService::log(
            'Updated',
            'ReceivablesLoans',
            "تم تعديل إجماليات موظف : {$receivablesLoans->employee->name}.",
            $receivablesLoans->getOriginal(),
            $receivablesLoans->getChanges()
        );
    }

    /**
     * Handle the ReceivablesLoans "deleted" event.
     */
    public function deleted(ReceivablesLoans $receivablesLoans): void
    {
        ActivityLogService::log(
            'Deleted',
            'ReceivablesLoans',
            "تم حذف إجماليات الموظف : {$receivablesLoans->employee->name}.",
            $receivablesLoans->toArray(),
            null
        );        
    }

    /**
     * Handle the ReceivablesLoans "restored" event.
     */
    public function restored(ReceivablesLoans $receivablesLoans): void
    {
        //
    }

    /**
     * Handle the ReceivablesLoans "force deleted" event.
     */
    public function forceDeleted(ReceivablesLoans $receivablesLoans): void
    {
        //
    }
}
