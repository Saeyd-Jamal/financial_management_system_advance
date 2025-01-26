<?php

namespace App\Observers;

use App\Models\Accreditation;
use App\Services\ActivityLogService;

class AccreditationObserver
{
    /**
     * Handle the Accreditation "created" event.
     */
    public function created(Accreditation $accreditation): void
    {
        ActivityLogService::log(
            'Created',
            'Accreditation',
            "تم إضافة إعتماد شهر  : {$accreditation->month}.",
            null,
            $accreditation->toArray()
        );
    }

    /**
     * Handle the Accreditation "updated" event.
     */
    public function updated(Accreditation $accreditation): void
    {
        ActivityLogService::log(
            'Updated',
            'Accreditation',
            "تم تعديل إعتماد شهر   : {$accreditation->month}.",
            $accreditation->getOriginal(),
            $accreditation->getChanges()
        );  
    }

    /**
     * Handle the Accreditation "deleted" event.
     */
    public function deleted(Accreditation $accreditation): void
    {
        ActivityLogService::log(
            'Deleted',
            'Accreditation',
            "تم حذف إعتماد شهر   : {$accreditation->month}.",
            $accreditation->toArray(),
            null
        );    
    }

    /**
     * Handle the Accreditation "restored" event.
     */
    public function restored(Accreditation $accreditation): void
    {
        //
    }

    /**
     * Handle the Accreditation "force deleted" event.
     */
    public function forceDeleted(Accreditation $accreditation): void
    {
        //
    }
}
