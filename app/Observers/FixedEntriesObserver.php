<?php

namespace App\Observers;

use App\Models\FixedEntries;
use App\Services\ActivityLogService;

class FixedEntriesObserver
{
    /**
     * Handle the FixedEntries "created" event.
     */
    public function created(FixedEntries $fixedEntries): void
    {
        ActivityLogService::log(
            'Created',
            'FixedEntries',
            "تم إضافة التعديلات للموظف : {$fixedEntries->employee->name}.",
            null,
            $fixedEntries->toArray()
        );    
    }

    /**
     * Handle the FixedEntries "updated" event.
     */
    public function updated(FixedEntries $fixedEntries): void
    {
        ActivityLogService::log(
            'Updated',
            'FixedEntries',
            "تم تعديل بيانات التعديلات للموظف  : {$fixedEntries->employee->name}.",
            $fixedEntries->getOriginal(),
            $fixedEntries->getChanges()
        );    
    }

    /**
     * Handle the FixedEntries "deleted" event.
     */
    public function deleted(FixedEntries $fixedEntries): void
    {
        ActivityLogService::log(
            'Deleted',
            'FixedEntries',
            "تم حذف بيانات التعديلات للموظف  : {$fixedEntries->employee->name}.",
            $fixedEntries->toArray(),
            null
        );
    }

    /**
     * Handle the FixedEntries "restored" event.
     */
    public function restored(FixedEntries $fixedEntries): void
    {
        //
    }

    /**
     * Handle the FixedEntries "force deleted" event.
     */
    public function forceDeleted(FixedEntries $fixedEntries): void
    {
        //
    }
}
