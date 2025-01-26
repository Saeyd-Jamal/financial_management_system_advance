<?php

namespace App\Observers;

use App\Models\Exchange;
use App\Services\ActivityLogService;

class ExchangeObserver
{
    /**
     * Handle the Exchange "created" event.
     */
    public function created(Exchange $exchange): void
    {
        ActivityLogService::log(
            'Created',
            'Exchange',
            "تم إضافة صرف للموظف : {$exchange->employee->name}.",
            null,
            $exchange->toArray()
        );
    }

    /**
     * Handle the Exchange "updated" event.
     */
    public function updated(Exchange $exchange): void
    {
        ActivityLogService::log(
            'Updated',
            'Exchange',
            "تم تعديل بيانات صرف للموظف  : {$exchange->employee->name}.",
            $exchange->getOriginal(),
            $exchange->getChanges()
        );    
    }

    /**
     * Handle the Exchange "deleted" event.
     */
    public function deleted(Exchange $exchange): void
    {
        ActivityLogService::log(
            'Deleted',
            'Exchange',
            "تم حذف بيانات صرف للموظف  : {$exchange->employee->name}.",
            $exchange->toArray(),
            null
        );    
    }

    /**
     * Handle the Exchange "restored" event.
     */
    public function restored(Exchange $exchange): void
    {
        //
    }

    /**
     * Handle the Exchange "force deleted" event.
     */
    public function forceDeleted(Exchange $exchange): void
    {
        //
    }
}
