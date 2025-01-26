<?php

namespace App\Observers;

use App\Models\Bank;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Log;

class BankObserver
{
    /**
     * Handle the Bank "created" event.
     */
    public function created(Bank $bank): void
    {
        ActivityLogService::log(
            'Created',
            'Bank',
            "تم إضافة بنك : {$bank->name}.",
            null,
            $bank->toArray()
        );
    }

    /**
     * Handle the Bank "updated" event.
     */
    public function updated(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "deleted" event.
     */
    public function deleted(Bank $bank): void
    {
        ActivityLogService::log(
            'Deleted',
            'Bank',
            "تم حذف بنك : {$bank->name}.",
            $bank->toArray(),
            null
        );
    }

    /**
     * Handle the Bank "restored" event.
     */
    public function restored(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "force deleted" event.
     */
    public function forceDeleted(Bank $bank): void
    {
        //
    }
}
