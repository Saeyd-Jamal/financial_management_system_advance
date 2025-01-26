<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Accreditation;
use App\Models\Bank;
use App\Models\BanksEmployees;
use App\Models\Constant;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Exchange;
use App\Models\FixedEntries;
use App\Models\Loan;
use App\Models\ReceivablesLoans;
use App\Models\SpecificSalary;
use App\Models\User;
use App\Observers\AccountObserver;
use App\Observers\AccreditationObserver;
use App\Observers\BankObserver;
use App\Observers\ConstantObserver;
use App\Observers\CurrencyObserver;
use App\Observers\EmployeeObserver;
use App\Observers\ExchangeObserver;
use App\Observers\FixedEntriesObserver;
use App\Observers\LoanObserver;
use App\Observers\ReceivablesLoansObserver;
use App\Observers\SpecificSalaryObserver;
use App\Observers\UserObserver;
use App\Policies\BankEmployeePolicy;
use App\Policies\CurrencyPolicy;
use App\Policies\FixedEntriesPolicy;
use App\Policies\ReceivablesLoansPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind('abilities', function() {
            return include base_path('data/abilities.php');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrapFive();


        //Authouration
        Gate::before(function ($user, $ability) {
            if($user instanceof User) {
                if($user->super_admin) {
                    return true;
                }
            }
        });
        // the Authorization for Report Page
        Gate::define('admins.super', function ($user) {
            if($user instanceof User) {
                if($user->roles->contains('role_name', 'admins.super')) {
                    return true;
                }
                return false;
            }
        });
        Gate::define('report.view', function ($user) {
            if($user instanceof User) {
                if($user->roles->contains('role_name', 'report.view')) {
                    return true;
                }
                return false;
            }
        });
        Gate::policy(FixedEntries::class, FixedEntriesPolicy::class);
        // Gate::policy(Currency::class, CurrencyPolicy::class);




        // Observe For Models
        User::observe(UserObserver::class);
        Constant::observe(ConstantObserver::class);
        Currency::observe(CurrencyObserver::class);
        Employee::observe(EmployeeObserver::class);
        Bank::observe(BankObserver::class);
        Account::observe(AccountObserver::class);
        ReceivablesLoans::observe(ReceivablesLoansObserver::class);
        Loan::observe(LoanObserver::class);
        FixedEntries::observe(FixedEntriesObserver::class);
        Exchange::observe(ExchangeObserver::class);
        SpecificSalary::observe(SpecificSalaryObserver::class);
        Accreditation::observe(AccreditationObserver::class);
        
    }
}
