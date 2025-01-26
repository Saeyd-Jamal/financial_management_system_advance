<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo"  style="overflow: visible">
        <a href="{{ route('dashboard.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="overflow: visible">
                <img src=" {{ asset('imgs/logo.png') }}" alt="Logo" width="60">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{ $title }}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">العامة</span>
        </li>
        <!-- Page -->
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}" class="menu-link">
                <i class="fa-solid fa-house me-2"></i>
                <div data-i18n="home">الرئيسية</div>
            </a>
        </li>
        @can('view','App\\Models\Employee')
        <li class="menu-item {{ request()->is('employees/*') || request()->is('employees') ? 'active' : '' }}">
            <a href="{{ route('dashboard.employees.index') }}" class="menu-link">
                <i class="fa-solid fa-users me-2"></i>
                <div data-i18n="employees">الموظفين</div>
            </a>
        </li>
        @endcan
        @can('report.view')
        <li class="menu-item {{ request()->is('report/*') || request()->is('report') ? 'active' : '' }}">
            <a href="{{ route('dashboard.report.index') }}" class="menu-link">
                <i class="fa-solid fa-file me-2"></i>
                <div data-i18n="report">التقارير</div>
            </a>
        </li>
        @endcan
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">قسم المالية</span>
        </li>
        @can('view','App\\Models\Salary')
        <li class="menu-item {{ request()->is('salaries/*') || request()->is('salaries') ? 'active' : '' }}">
            <a href="{{ route('dashboard.salaries.index') }}" class="menu-link">
                <i class="fa-solid fa-vault me-2"></i>
                <div data-i18n="salaries">الرواتب</div>
            </a>
        </li> 
        @endcan
        @can('view','App\\Models\SpecificSalary')
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-money-bill-transfer me-2"></i>
                <div data-i18n="settings">الرواتب المحددة</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('specific_salaries/*') || request()->is('specific_salaries') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.specific_salaries.index') }}" class="menu-link">
                        <i class="fa-solid fa-wallet me-2"></i>
                        <div data-i18n="specific_salaries">الكل</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('specific_salaries_ratio/*') || request()->is('specific_salaries_ratio') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.specific_salaries.ratio') }}" class="menu-link">
                        <i class="fa-solid fa-money-bill-trend-up me-2"></i>
                        <div data-i18n="ratio">النسبة</div>
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        @if (Auth::user()->can('view','App\\Models\ReceivablesLoans') || Auth::user()->can('view','App\\Models\Loan'))
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-sack-dollar me-2"></i>
                <div data-i18n="settings">الإجماليات والقروض</div>
            </a>
            <ul class="menu-sub">
                @can('view','App\\Models\ReceivablesLoans')
                <li class="menu-item {{ request()->is('receivables/*') || request()->is('receivables') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.receivables.index') }}" class="menu-link">
                        <i class="fa-solid fa-scale-balanced me-2"></i>
                        <div data-i18n="receivables">المستحقات</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('savings/*') || request()->is('savings') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.savings.index') }}" class="menu-link">
                        <i class="fa-solid fa-scale-unbalanced me-2"></i>
                        <div data-i18n="savings">الإدخارات</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\Loan')
                <li class="menu-item {{ request()->is('loans/*') || request()->is('loans') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.loans.index') }}" class="menu-link">
                        <i class="fa-solid fa-receipt me-2"></i>
                        <div data-i18n="loans">القروض</div>
                    </a>
                </li>
                @endcan                
            </ul>
        </li>
        @endif
        @if (Auth::user()->can('view','App\\Models\FixedEntries') || Auth::user()->can('view','App\\Models\Exchange'))
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-money-check-dollar me-2"></i>
                <div data-i18n="settings">الأمور المالية</div>
            </a>
            <ul class="menu-sub">
                @can('view','App\\Models\FixedEntries')
                <li class="menu-item {{ request()->is('fixed_entries/*') || request()->is('fixed_entries') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.fixed_entries.index') }}" class="menu-link">
                        <i class="fa-solid fa-keyboard me-2"></i>
                        <div data-i18n="fixed_entries">التعديلات</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\Exchange')
                <li class="menu-item {{ request()->is('exchanges/*') || request()->is('exchanges') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.exchanges.index') }}" class="menu-link">
                        <i class="fa-solid fa-filter-circle-dollar me-2"></i>
                        <div data-i18n="exchanges">الصرف</div>
                    </a>
                </li>
                @endcan
                {{-- <li class="menu-item {{ request()->is('exchanges/*') || request()->is('exchanges') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.exchanges.index') }}" class="menu-link">
                        <i class="fa-solid fa-hand-holding-dollar me-2"></i>
                        <div data-i18n="exchanges">صرف المكافئات</div>
                    </a>
                </li> --}}
            </ul>
        </li>
        @endif
        
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">إدارة النظام</span>
        </li>
        @if (Auth::user()->can('view','App\\Models\SalaryScale') || Auth::user()->can('view','App\\Models\Bank') || Auth::user()->can('view','App\\Models\Account'))
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-database me-2"></i>
                <div data-i18n="settings">البيانات الأخرى</div>
            </a>
            <ul class="menu-sub">
                @can('view','App\\Models\SalaryScale')
                <li class="menu-item {{ request()->is('salary_scales/*') || request()->is('salary_scales') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.salary_scales.index') }}" class="menu-link">
                        <i class="fa-solid fa-table me-2"></i>
                        <div data-i18n="table">سلم الرواتب</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\Bank')
                <li class="menu-item {{ request()->is('banks/*') || request()->is('banks') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.banks.index') }}" class="menu-link">
                        <i class="fa-solid fa-building-columns me-2"></i>
                        <div data-i18n="table">البنوك</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\Account')
                <li class="menu-item {{ request()->is('accounts/*') || request()->is('accounts') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.accounts.index') }}" class="menu-link">
                        <i class="fa-solid fa-money-check me-2"></i>
                        <div data-i18n="table">حسابات البنوك</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        @if (Auth::user()->can('view','App\\Models\User') || Auth::user()->can('view','App\\Models\ActivityLog') || Auth::user()->can('view','App\\Models\Constant') || Auth::user()->can('view','App\\Models\Currency'))
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-gear me-2"></i>
                <div data-i18n="settings">الإعدادات</div>
            </a>
            <ul class="menu-sub">
                @can('view','App\\Models\User')
                <li class="menu-item {{ request()->is('users/*') || request()->is('users') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                        <i class="fa-solid fa-users me-2"></i>
                        <div data-i18n="users">المستخدمين</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\ActivityLog')
                <li class="menu-item {{ request()->is('logs/*') || request()->is('logs') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.logs.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="logs">الأحداث</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\Constant')
                <li class="menu-item {{ request()->is('constants/*') || request()->is('constants') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.constants.index') }}" class="menu-link">
                        <i class="fa-solid fa-cube me-2"></i>
                        <div data-i18n="constants">ثوابت النظام</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\Currency')
                <li class="menu-item {{ request()->is('currencies/*') || request()->is('currencies') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.currencies.index') }}" class="menu-link">
                        <i class="fa-solid fa-coins me-2"></i>
                        <div data-i18n="currencies">العملات</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        {{-- <li class="menu-item">
            <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <i class="fa-solid fa-house me-2"></i>
                <div data-i18n="Page 2">Page 2</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="index.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-chart-pie-2"></i>
                        <div data-i18n="Analytics">Analytics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="dashboards-crm.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-3d-cube-sphere"></i>
                        <div data-i18n="CRM">CRM</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-ecommerce-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                        <div data-i18n="eCommerce">eCommerce</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-logistics-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-truck"></i>
                        <div data-i18n="Logistics">Logistics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-academy-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-book"></i>
                        <div data-i18n="Academy">Academy</div>
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
    <div class="text-body text-white text-center my-3">
        ©
        2025
        , تم الإنشاء ❤️ بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank"
            class="footer-link">م . السيد الاخرسي</a>
    </div>
</aside>