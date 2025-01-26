<?php

namespace App\Observers;

use App\Models\Account;
use App\Services\ActivityLogService;

class AccountObserver
{
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        ActivityLogService::log(
            'Created',
            'Account',
            "تم إضافة حساب بنك : {$account->employee->name}.",
            null,
            $account->toArray()
        );
    }

    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        ActivityLogService::log(
            'Deleted',
            'Account',
            "تم حذف حساب بنك : {$account->employee->name}.",
            $account->toArray(),
            null
        );
    }

    /**
     * Handle the Account "restored" event.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}
