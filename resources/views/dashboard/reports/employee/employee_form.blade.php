<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>استمار موظف</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'XBRiyaz', sans-serif;
        }
        @page {
            header: page-header;
            footer: page-footer;
        }
        hr {
            right: 25px;
        }
        html {
            direction: rtl;
        }

        .head_td{
            text-align: right;
        }
        h3 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1em;
        }
    </style>
    <style>
        .container {
            max-width: 100%;
            margin: 0 10px;
        }

        .personal-info-title {
            text-align: center;
            color: #632423;
        }

        .table-responsive {
            text-align: justify;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td {
            padding: 12px;
            border: 1px solid #000000;
            font-size: 35px;
        }

        .head_td {
            background: #d6e3bc;
            font-weight: bold;
            width: 350px;
            font-size: 35px;
        }

        .data_td {
            background: #fdf8ed;
            color: #000000;
        }

        /* Specific width adjustments */
        .gender-label {
            width: 207px;
        }

        .wide-cell {
            width: 800px;
        }

        .medium-cell {
            width: 700px;
        }

        .relation-label {
            width: 366px;
        }

        /* Table responsiveness */
        @media screen and (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table td {
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
        @if ($employee->workData->association == "المدينة")
            <img src="{{ public_path('imgs/headers/city_architecture.jpg') }}" alt="">
        @elseif ($employee->workData->association == "حطين")
            <img src="{{ public_path('imgs/headers/hetten.png') }}" alt="">
        @elseif ($employee->workData->association == "الكويتي")
            <img src="{{ public_path('imgs/headers/Kuwaiti.jpg') }}" alt="">
        @elseif ($employee->workData->association == "يتيم")
            <img src="{{ public_path('imgs/headers/orphan.jpg') }}" alt="">
        @elseif ($employee->workData->association == "صلاح")
            <img src="{{ public_path('imgs/headers/salah.png') }}" alt="">
        @endif
    </htmlpageheader>

    <div id="content" lang="ar" style="margin-top: 5em;">
        <div class="container">
            <h3 class="personal-info-title" style="margin-bottom: 1.5em; ">
                {{ $employee->workData->payroll_statement }}
                <br>
                رواتب شهر  {{ $monthName }} - {{ $year }}م
            </h3>
            <div class="table-responsive"  style="margin: 0 2.5em;">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="head_td">رقم الهوية :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->employee_id }}
                            </td>
                            <td class="head_td gender-label">عدد الأولاد  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->number_children }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">اسم الموظف :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->name }}
                            </td>
                            <td class="head_td gender-label">العلاوة - الدرجة  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->workData->allowance }} - {{ $employee->workData->grade }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td"> اسم البنك:</td>
                            <td class="data_td wide-cell">
                                {{ $salaries->bank }}
                            </td>
                            <td class="head_td gender-label">مكان العمل  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->workData->workplace }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">رقم الحساب :</td>
                            <td class="data_td wide-cell">
                                {{ $salaries->account_number }}
                            </td>
                            <td class="head_td gender-label">الحالة الإجتماعية  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->matrimonial_status }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">رقم الموظف :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->id }}
                            </td>
                            <td class="head_td gender-label">نوع التعيين  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->workData->type_appointment }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">الأقدمية الفعلية :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->workData->years_service }}
                            </td>
                            <td class="head_td gender-label">  &nbsp;</td>
                            <td class="data_td medium-cell">

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container" style="margin: 1.5em 3em 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td class="head_td" style="text-align: center; font-size: 50px" colspan="2">الاستحقاقات </td>
                            <td class="head_td gender-label" style="text-align: center; font-size: 50px" colspan="2">الاستقطاعات</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="head_td">راتب أساسي :</td>
                            <td class="data_td wide-cell">
                                {{$salaries->secondary_salary}}
                            </td>
                            <td class="head_td gender-label">الضريبة  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{0.00}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة الأولاد :</td>
                            <td class="data_td wide-cell">
                                {{$salaries->allowance_boys}}
                            </td>
                            <td class="head_td gender-label">تأمين صحي  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->health_insurance}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">طبيعة عمل :</td>
                            <td class="data_td wide-cell">
                                {{$salaries->nature_work_increase}}
                            </td>
                            <td class="head_td gender-label">مكافأة نهاية الخدمة  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$salaries->termination_service}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">مواصلات :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->transport}}
                            </td>
                            <td class="head_td gender-label">الإدخار 5%  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->savings_rate}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة إدارية :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->administrative_allowance}}
                            </td>
                            <td class="head_td gender-label">فاتورة أوريدو  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->f_Oredo}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة مؤهل علمي :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->scientific_qualification_allowance}}
                            </td>
                            <td class="head_td gender-label">خصومات أخرى  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->other_discounts}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">مكافئة نهاية الخدمة :</td>
                            <td class="data_td wide-cell">
                                {{$salaries->termination_service}}
                            </td>
                            <td class="head_td gender-label">تبرعات :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->voluntary_contributions}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة جوال :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->mobile_allowance}}
                            </td>
                            <td class="head_td gender-label">قرض الإدخار  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$salaries->savings_loan * $USD}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">إضافة بأثر رجعي :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->ex_addition}}
                            </td>
                            <td class="head_td gender-label">قرض جمعية ش  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$salaries->association_loan}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">بدل إضافي :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->extra_allowance}}
                            </td>
                            <td class="head_td gender-label">قرض اللجنة (شيكل)  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$salaries->shekel_loan}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة أغراض الراتب :</td>
                            <td class="data_td wide-cell">
                                {{$fixedEntries->salary_allowance}}
                            </td>
                            <td class="head_td gender-label">خصم اللجنة  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->paradise_discount}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td"> </td>
                            <td class="data_td wide-cell">

                            </td>
                            <td class="head_td gender-label">رسوم دراسية  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$fixedEntries->tuition_fees}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td"> </td>
                            <td class="data_td wide-cell">

                            </td>
                            <td class="head_td gender-label">مستحقات  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{$salaries->late_receivables}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">الإجمالي :</td>
                            <td class="data_td wide-cell">
                                {{
                                    $total_receivables = ($salaries->secondary_salary + $salaries->allowance_boys + $salaries->nature_work_increase +
                                    $fixedEntries->transport + $fixedEntries->administrative_allowance + $fixedEntries->scientific_qualification_allowance + $salaries->termination_service + $fixedEntries->mobile_allowance + $fixedEntries->ex_addition + $fixedEntries->extra_allowance + $fixedEntries->salary_allowance)
                                }}
                            </td>
                            <td class="head_td gender-label">الإجمالي  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{
                                    $total_deductions = ($fixedEntries->health_insurance + $salaries->termination_service +
                                    $fixedEntries->savings_rate + $fixedEntries->f_Oredo + $fixedEntries->other_discounts +
                                    $fixedEntries->voluntary_contributions + ($salaries->savings_loan * $USD) + $salaries->association_loan + $salaries->shekel_loan + $fixedEntries->paradise_discount +
                                    $fixedEntries->tuition_fees + $salaries->late_receivables)
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">صافي الراتب :</td>
                            <td class="data_td wide-cell">
                                {{ number_format($total_receivables - $total_deductions,0) }}
                            </td>
                            <td class="head_td gender-label">بالحروف  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $salaries->amount_letters }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container" style="margin: 1.5em 3em 0;">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="head_td">الإدخار ومكافأة الخدمة التراكمي :</td>
                            <td class="data_td wide-cell">
                                {{number_format($employee->totals->total_savings - ($salaries->savings_loan + (($salaries->savings_rate + $salaries->termination_service) / $USD )),2)}}
                            </td>
                            <td class="head_td gender-label">الإدخار الشهري ومكافأة نهاية الخدمة  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{number_format((($salaries->savings_rate + $salaries->termination_service) / $USD ),2)}}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">قيمة القسط الشهري :</td>
                            <td class="data_td wide-cell">
                                {{number_format($salaries->savings_loan,2)}}
                            </td>
                            <td class="head_td gender-label">إجمالي الادخار ومكافأة نهاية الخدمة  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{number_format($employee->totals->total_savings,2)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container" style="margin: 1.5em 3em 0;">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="head_td">الاستحقاق المتراكم :</td>
                            <td class="head_td">الاستحقاق الشهري :</td>
                            <td class="head_td">اجمالي الاستحقاق :</td>
                        </tr>
                        <tr>
                            <td class="data_td wide-cell">
                                {{number_format($employee->totals->total_receivables - $salaries->late_receivables,2)}}
                            </td>
                            <td class="data_td medium-cell">
                                {{number_format($salaries->late_receivables,2)}}
                            </td>
                            <td class="data_td medium-cell">
                                {{number_format($employee->totals->total_receivables,2)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <tr>
            <td class="head_td"> :</td>
            <td class="data_td wide-cell"></td>
            <td class="head_td gender-label">  :&nbsp;</td>
            <td class="data_td medium-cell"></td>
        </tr> --}}
        <htmlpagefooter name="page-footer">
            <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    @auth
                        <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
                    @else
                        <td width="33%" style="text-align: left;">اسم المستخدم</td>
                    @endauth
                </tr>
            </table>
        </htmlpagefooter>
    </div>
</body>

</html>
