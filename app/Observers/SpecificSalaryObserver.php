<?php

namespace App\Observers;

use App\Models\SpecificSalary;
use App\Services\ActivityLogService;

class SpecificSalaryObserver
{
    /**
     * Handle the SpecificSalary "created" event.
     */
    public function created(SpecificSalary $specificSalary): void
    {
        ActivityLogService::log(
            'Created',
            'SpecificSalary',
            "تم إضافة راتب الموظف : {$specificSalary->employee->name}.",
            null,
            $specificSalary->toArray()
        );
    }

    /**
     * Handle the SpecificSalary "updated" event.
     */
    public function updated(SpecificSalary $specificSalary): void
    {
        ActivityLogService::log(
            'Updated',
            'SpecificSalary',
            "تم تعديل بيانات راتب الموظف : {$specificSalary->employee->name}.",
            $specificSalary->getOriginal(),
            $specificSalary->getChanges()
        );
    }

    /**
     * Handle the SpecificSalary "deleted" event.
     */
    public function deleted(SpecificSalary $specificSalary): void
    {
        ActivityLogService::log(
            'Deleted',
            'SpecificSalary',
            "تم حذف بيانات راتب الموظف : {$specificSalary->employee->name}.",
            $specificSalary->toArray(),
            null
        ); 
    }

    /**
     * Handle the SpecificSalary "restored" event.
     */
    public function restored(SpecificSalary $specificSalary): void
    {
        //
    }

    /**
     * Handle the SpecificSalary "force deleted" event.
     */
    public function forceDeleted(SpecificSalary $specificSalary): void
    {
        //
    }
}
