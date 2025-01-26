<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف صرف لموظف</title>
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
            font-size: 45px;
        }

        .head_td {
            background: #d6e3bc;
            font-weight: bold;
            width: 350px;
            font-size: 45px;
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
@php
    $exchangeType = $exchange->exchange_type == 'receivables_discount' ? 'من المستحقات ش' : '';
    $exchangeType = $exchange->exchange_type == 'savings_discount' ? 'من الإدخارات $' : $exchangeType;
    $exchangeType = $exchange->exchange_type == 'association_loan' ? 'قرض جمعية ش' : $exchangeType;
    $exchangeType = $exchange->exchange_type == 'savings_loan' ? 'قرض إدخار $' : $exchangeType;
    $exchangeType = $exchange->exchange_type == 'shekel_loan' ? 'قرض لجنة  ش' : $exchangeType;
    $exchangeType = $exchange->exchange_type == 'reward' ? 'مكافأة مالية' : $exchangeType;
@endphp
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
            <h3 class="personal-info-title" style="margin-bottom: 2em; ">كشف صرف {{ $exchangeType }} للموظف : "{{ $employee->name }}"</h3>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="head_td">رقم الهوية :</td>
                            <td class="data_td wide-cell">{{ $employee->id }}</td>
                            <td class="head_td gender-label">تاريخ العمل  :&nbsp;</td>
                            <td class="data_td medium-cell">{{ $employee->workData->working_date }}</td>
                        </tr>
                        <tr>
                            <td class="head_td">قيمة الصرف :</td>
                            <td class="data_td wide-cell">
                                @if ($exchange->exchange_type == 'receivables_discount')
                                    {{ $exchange->receivables_discount }}
                                @elseif( $exchange->exchange_type == 'savings_discount')
                                    {{ $exchange->savings_discount }}
                                @elseif( $exchange->exchange_type == 'association_loan')
                                    {{ $exchange->association_loan }}
                                @elseif( $exchange->exchange_type == 'savings_loan')
                                    {{ $exchange->savings_loan }}
                                @elseif( $exchange->exchange_type == 'shekel_loan')
                                    {{ $exchange->shekel_loan }}
                                @elseif( $exchange->exchange_type == 'reward')
                                    {{ $exchange->reward }}
                                @endif
                            </td>
                            <td class="head_td gender-label">تاريخ الصرف  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $exchange->exchange_date }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">الرصيد السابق :</td>
                            <td class="data_td wide-cell">
                                @if ($exchange->exchange_type == 'receivables_discount')
                                    {{ $employee->totals->total_receivables - $exchange->receivables_discount }}
                                @elseif( $exchange->exchange_type == 'savings_discount')
                                    {{ $employee->totals->total_savings - $exchange->savings_discount }}
                                @elseif( $exchange->exchange_type == 'association_loan')
                                    {{ $employee->totals->total_association_loan - $exchange->association_loan }}
                                @elseif( $exchange->exchange_type == 'savings_loan')
                                    {{ $employee->totals->total_savings_loan - $exchange->savings_loan }}
                                @elseif( $exchange->exchange_type == 'shekel_loan')
                                    {{ $employee->totals->total_shekel_loan - $exchange->shekel_loan }}
                                @endif
                            </td>
                            <td class="head_td gender-label">الرصيد الحالي  :&nbsp;</td>
                            <td class="data_td medium-cell">
                                @if ($exchange->exchange_type == 'receivables_discount')
                                    {{ $employee->totals->total_receivables}}
                                @elseif( $exchange->exchange_type == 'savings_discount')
                                    {{ $employee->totals->total_savings}}
                                @elseif( $exchange->exchange_type == 'association_loan')
                                    {{ $employee->totals->total_association_loan }}
                                @elseif( $exchange->exchange_type == 'savings_loan')
                                    {{ $employee->totals->total_savings_loan }}
                                @elseif( $exchange->exchange_type == 'shekel_loan')
                                    {{ $employee->totals->total_shekel_loan }}
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td class="head_td"> سبب الصرف :</td>
                            <td class="data_td wide-cell" colspan="3">
                                {{ $exchange->notes }}
                            </td>
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
