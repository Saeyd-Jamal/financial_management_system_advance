<?php

namespace App\Observers;

use App\Models\Employee;
use App\Services\ActivityLogService;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        ActivityLogService::log(
            'Created',
            'Employee',
            "تم إضافة الموظف : {$employee->name}.",
            null,
            $employee->toArray()
        );
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        ActivityLogService::log(
            'Updated',
            'Employee',
            "تم تعديل بيانات الموظف  : {$employee->name}.",
            [
                $employee->getOriginal(),
                $employee->workData->getOriginal()
            ],
            [
                $employee->getChanges(),
                $employee->workData->getChanges()
            ]
        );    
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        ActivityLogService::log(
            'Deleted',
            'Employee',
            "تم حذف بيانات الموظف  : {$employee->name}.",
            $employee->toArray(),
            null
        );    
    }

    /**
     * Handle the Employee "restored" event.
     */
    public function restored(Employee $employee): void
    {
        //
    }
    /**
     * Handle the Employee "force deleted" event.
     */
    public function forceDeleted(Employee $employee): void
    {
        //
    }
}
