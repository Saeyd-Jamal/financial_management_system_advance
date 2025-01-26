<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف راتب</title>
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
            text-align: right;
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
            <div style="margin: 1em 0;">
                <div style="float: left; width: 50%; text-align: left;">
                    <p style="margin-bottom: 0;">{{Carbon\Carbon::now()->format('Y-m-d')}}</p>
                </div>
            </div>
            <h3 class="personal-info-title" style="margin-bottom: 2em; ">كشف راتب للموظف : "{{ $employee->name }}" لشهر : {{ $monthAr }} - {{ $year }} </h3>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="head_td">الاسم :</td>
                            <td class="data_td wide-cell">{{ $employee->name }}</td>
                            <td class="head_td  gender-label">مكان العمل :</td>
                            <td class="data_td medium-cell">{{ $employee->workData->workplace ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">العلاوة :</td>
                            <td class="data_td wide-cell">{{ $employee->workData->allowance ?? '' }}</td>
                            <td class="head_td gender-label">الدرجة :</td>
                            <td class="data_td medium-cell">{{ $employee->workData->grade ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">الراتب الأولي :</td>
                            <td class="data_td wide-cell">{{ $salaries->initial_salary ?? '' }}</td>
                            <td class="head_td gender-label">علاوة درجة :</td>
                            <td class="data_td wide-cell">{{ $salaries->grade_Allowance ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">الراتب الأساسي :</td>
                            <td class="data_td wide-cell">{{ $salaries->secondary_salary ?? '' }}</td>
                            <td class="head_td gender-label">ع الأولاد :</td>
                            <td class="data_td medium-cell">{{ $salaries->allowance_boys ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">طبيعة عمل :</td>
                            <td class="data_td wide-cell">{{ $salaries->nature_work_increase ?? '' }}</td>
                            <td class="head_td gender-label">علاوة إدارية :</td>
                            <td class="data_td medium-cell">{{ $fixedEntries->administrative_allowance ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">مواصلات :</td>
                            <td class="data_td wide-cell">{{ $fixedEntries->transport ?? '' }}</td>
                            <td class="head_td gender-label">بدل إضافي :</td>
                            <td class="data_td medium-cell">{{ $fixedEntries->extra_allowance ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة أغراض راتب :</td>
                            <td class="data_td wide-cell">{{ $fixedEntries->salary_allowance ?? '' }}</td>
                            <td class="head_td gender-label">إضافة بأثر رجعي :</td>
                            <td class="data_td medium-cell">{{ $fixedEntries->ex_addition ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">علاوة جوال :</td>
                            <td class="data_td wide-cell">{{ $fixedEntries->mobile_allowance ?? '' }}</td>
                            <td class="head_td gender-label">نهاية خدمة :</td>
                            <td class="data_td medium-cell">{{ $salaries->termination_service ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">إجمالي الراتب :</td>
                            <td class="data_td wide-cell">{{ $salaries->gross_salary ?? '' }}</td>
                            <td class="head_td gender-label">تأمين صحي :</td>
                            <td class="data_td medium-cell">{{ $fixedEntries->health_insurance ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">ض.دخل :</td>
                            <td class="data_td wide-cell">{{ $salaries->z_Income ?? '' }}</td>
                            <td class="head_td gender-label">إدخار 5% :</td>
                            <td class="data_td medium-cell">{{ $salaries->savings_rate ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">قرض جمعية :</td>
                            <td class="data_td wide-cell">{{ $salaries->association_loan ?? '' }}</td>
                            <td class="head_td gender-label">قرض لجنة :</td>
                            <td class="data_td medium-cell">{{ $salaries->shekel_loan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">قرض إدخار :</td>
                            <td class="data_td wide-cell">{{ $salaries->savings_loan ?? '' }}</td>
                            <td class="head_td gender-label">مستحقات متأخرة :</td>
                            <td class="data_td medium-cell">{{ $salaries->late_receivables ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">إجمالي الخصومات :</td>
                            <td class="data_td wide-cell">{{ $salaries->total_discounts ?? '' }}</td>
                            <td class="head_td gender-label">صافي الراتب :</td>
                            <td class="data_td medium-cell">{{ $salaries->net_salary ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="head_td gender-label">رقم حساب البنك :</td>
                            <td class="data_td medium-cell">{{ $salaries->bank ?? '' }}</td>
                            <td class="head_td gender-label">رقم حساب البنك :</td>
                            <td class="data_td medium-cell">{{ $salaries->account_number ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2em;">
                <div style="float: right; width: 100px; text-align: right; margin-right: 10px;">
                    <p>توقيع الموظف :</p>
                </div>
                <div style="float: left; width: 100px; text-align: left; margin-left: 10%;">
                    <p>الإعتماد:</p>
                </div>
            </div>
        </div>
        {{-- <tr>
            <td class="head_td"> :</td>
            <td class="data_td wide-cell"></td>
            <td class="head_td gender-label">  :&nbsp;</td>
            <td class="data_td medium-cell"></td>
        </tr> --}}

    </div>


</body>

</html>
