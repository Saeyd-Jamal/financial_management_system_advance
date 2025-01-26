<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف {{ $name_loan }}</title>
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
            <h3 class="personal-info-title" style="margin-bottom: 2em; ">كشف صرف {{ $name_loan }} للموظف : "{{ $employee->name }}"  لسنة : {{ $year }} </h3>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="head_td">يناير :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->loans->where('month',$year . '-' . '01')->first() ? $employee->loans->where('month',$year . '-' . '01')->first()[$field] : 0 }}
                            </td>
                            <td class="head_td gender-label"> يوليه :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->loans->where('month',$year . '-' . '07')->first() ? $employee->loans->where('month',$year . '-' . '07')->first()[$field] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">فبراير :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->loans->where('month',$year . '-' . '02')->first() ? $employee->loans->where('month',$year . '-' . '02')->first()[$field] : 0 }}
                            </td>
                            <td class="head_td gender-label"> أغسطس :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->loans->where('month',$year . '-' . '08')->first() ? $employee->loans->where('month',$year . '-' . '08')->first()[$field] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">مارس :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->loans->where('month',$year . '-' . '03')->first() ? $employee->loans->where('month',$year . '-' . '03')->first()[$field] : 0 }}
                            </td>
                            <td class="head_td gender-label"> سبتمبر :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->loans->where('month',$year . '-' . '09')->first() ? $employee->loans->where('month',$year . '-' . '09')->first()[$field] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">أبريل :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->loans->where('month',$year . '-' . '04')->first() ? $employee->loans->where('month',$year . '-' . '04')->first()[$field] : 0 }}
                            </td>
                            <td class="head_td gender-label"> أكتوبر :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->loans->where('month',$year . '-' . '10')->first() ? $employee->loans->where('month',$year . '-' . '10')->first()[$field] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">مايو :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->loans->where('month',$year . '-' . '05')->first() ? $employee->loans->where('month',$year . '-' . '05')->first()[$field] : 0 }}
                            </td>
                            <td class="head_td gender-label"> نوفمبر :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->loans->where('month',$year . '-' . '11')->first() ? $employee->loans->where('month',$year . '-' . '11')->first()[$field] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td">يونيو :</td>
                            <td class="data_td wide-cell">
                                {{ $employee->loans->where('month',$year . '-' . '06')->first() ? $employee->loans->where('month',$year . '-' . '06')->first()[$field] : 0 }}
                            </td>
                            <td class="head_td gender-label"> ديسمبر :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->loans->where('month',$year . '-' . '12')->first() ? $employee->loans->where('month',$year . '-' . '12')->first()[$field] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="head_td"> الرصيد السابق :</td>
                            <td class="data_td wide-cell">
                                {{ $previous_balance ?? 0 }}
                            </td>
                            <td class="head_td gender-label" >الإجمالي العام : :&nbsp;</td>
                            <td class="data_td medium-cell">
                                {{ $employee->totals[$total_field] ?? 0 }}
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
