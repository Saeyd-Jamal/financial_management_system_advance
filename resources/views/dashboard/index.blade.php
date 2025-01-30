<x-front-layout>
    <x-row />
    @push('styles')
        <style>
            /* Resize generated styles */

            @keyframes resizeanim {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 0;
                }
            }

            .resize-triggers {
                animation: 1ms resizeanim;
                visibility: hidden;
                opacity: 0;
            }

            .resize-triggers,
            .resize-triggers>div,
            .contract-trigger:before {
                content: " ";
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                overflow: hidden;
            }

            .resize-triggers>div {
                background: #eee;
                overflow: auto;
            }

            .contract-trigger:before {
                width: 200%;
                height: 200%;
            }
        </style>
    @endpush
    <h2>إحصائيات</h2>
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">تقرير المناطق لشهر : {{ $monthDownload }}</h5>
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنطقة</th>
                                <th>عدد الموظفين</th>
                                <th>إجمالي الراتب</th>
                                <th>صافي الراتب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workplaces as $workplace)
                                @php
                                    $employees = App\Models\Employee::query()
                                        ->whereHas('workData', function ($query) use ($workplace) {
                                            $query->where('workplace', $workplace);
                                        })
                                        ->get();
                                    $salaries = \App\Models\Salary::whereIn('employee_id', $employees->pluck('id'))
                                        ->where('salaries.month', $monthDownload)
                                        ->select('salaries.net_salary', 'salaries.gross_salary')
                                        ->get();

                                    $gross_salary = $salaries->sum('gross_salary');
                                    $net_salary = $salaries->sum('net_salary');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $workplace }}</td>
                                    <td>{{ App\Models\WorkData::where('workplace', $workplace)->count() }}</td>
                                    <td>{{ number_format($gross_salary, 2) }}</td>
                                    <td>{{ number_format($net_salary, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                @php
                                    $salaries = \App\Models\Salary::where('salaries.month', $monthDownload)
                                        ->select('salaries.net_salary', 'salaries.gross_salary')
                                        ->get();
                                    $gross_salary = $salaries->sum('gross_salary');
                                    $net_salary = $salaries->sum('net_salary');
                                @endphp
                                <td>{{ 00 }}</td>
                                <td>المجموع</td>
                                <td>{{ $countEmployees }}</td>
                                <td>{{ number_format($gross_salary, 2) }}</td>
                                <td>{{ number_format($net_salary, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-sm-6 overflow-hidden">
                <div class="card h-100  bg-primary">
                    <div class="card-header pb-0">
                        <h5 class="mb-3 card-title text-white">عدد الموظفين العام</h5>
                        {{-- <p class="mb-0 text-body">Total Sales This Month</p> --}}
                        <h4 class="mb-0 text-white">{{ $countEmployees }}</h4>
                    </div>
                    <div class="card-body px-0" style="position: relative;">
                        <div id="averageDailySales" style="min-height: 123px;">
                            <div id="apexchartsbl85khoe"
                                class="apexcharts-canvas apexchartsbl85khoe apexcharts-theme-light"
                                style="width: 520px; height: 123px;"><svg id="SvgjsSvg1676" width="520"
                                    height="123" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                                    class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                    style="background: transparent;">
                                    <g id="SvgjsG1678" class="apexcharts-inner apexcharts-graphical"
                                        transform="translate(0, 0)">
                                        <defs id="SvgjsDefs1677">
                                            <clipPath id="gridRectMaskbl85khoe">
                                                <rect id="SvgjsRect1683" width="526" height="125" x="-3" y="-1"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMaskbl85khoe"></clipPath>
                                            <clipPath id="nonForecastMaskbl85khoe"></clipPath>
                                            <clipPath id="gridRectMarkerMaskbl85khoe">
                                                <rect id="SvgjsRect1684" width="524" height="127" x="-2" y="-2"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <linearGradient id="SvgjsLinearGradient1689" x1="0" y1="0"
                                                x2="0" y2="1">
                                                <stop id="SvgjsStop1690" stop-opacity="0.6"
                                                    stop-color="rgba(40,199,111,0.6)" offset="0"></stop>
                                                <stop id="SvgjsStop1691" stop-opacity="0.1"
                                                    stop-color="rgba(212,244,226,0.1)" offset="1"></stop>
                                                <stop id="SvgjsStop1692" stop-opacity="0.1"
                                                    stop-color="rgba(212,244,226,0.1)" offset="1"></stop>
                                            </linearGradient>
                                        </defs>
                                        <line id="SvgjsLine1682" x1="0" y1="0" x2="0"
                                            y2="123" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt"
                                            class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="123"
                                            fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                        <g id="SvgjsG1695" class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g id="SvgjsG1696" class="apexcharts-xaxis-texts-g"
                                                transform="translate(0, -4)"></g>
                                        </g>
                                        <g id="SvgjsG1702" class="apexcharts-grid">
                                            <g id="SvgjsG1703" class="apexcharts-gridlines-horizontal"
                                                style="display: none;">
                                                <line id="SvgjsLine1705" x1="0" y1="0"
                                                    x2="520" y2="0" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1706" x1="0" y1="20.5"
                                                    x2="520" y2="20.5" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1707" x1="0" y1="41"
                                                    x2="520" y2="41" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1708" x1="0" y1="61.5"
                                                    x2="520" y2="61.5" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1709" x1="0" y1="82"
                                                    x2="520" y2="82" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1710" x1="0" y1="102.5"
                                                    x2="520" y2="102.5" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1711" x1="0" y1="123"
                                                    x2="520" y2="123" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                            </g>
                                            <g id="SvgjsG1704" class="apexcharts-gridlines-vertical"
                                                style="display: none;"></g>
                                            <line id="SvgjsLine1713" x1="0" y1="123" x2="520"
                                                y2="123" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                            <line id="SvgjsLine1712" x1="0" y1="1" x2="0"
                                                y2="123" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                        </g>
                                        <g id="SvgjsG1685" class="apexcharts-area-series apexcharts-plot-series">
                                            <g id="SvgjsG1686" class="apexcharts-series" seriesName="seriesx1"
                                                data:longestSeries="true" rel="1" data:realIndex="0">
                                                <path id="SvgjsPath1693"
                                                    d="M 0 123L 0 61.5C 60.66666666666666 61.5 112.66666666666666 102.5 173.33333333333331 102.5C 233.99999999999997 102.5 286 10.25 346.66666666666663 10.25C 407.3333333333333 10.25 459.3333333333333 41 520 41C 520 41 520 41 520 123M 520 41z"
                                                    fill="url(#SvgjsLinearGradient1689)" fill-opacity="1"
                                                    stroke-opacity="1" stroke-linecap="butt" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-area" index="0"
                                                    clip-path="url(#gridRectMaskbl85khoe)"
                                                    pathTo="M 0 123L 0 61.5C 60.66666666666666 61.5 112.66666666666666 102.5 173.33333333333331 102.5C 233.99999999999997 102.5 286 10.25 346.66666666666663 10.25C 407.3333333333333 10.25 459.3333333333333 41 520 41C 520 41 520 41 520 123M 520 41z"
                                                    pathFrom="M -1 143.5L -1 143.5L 173.33333333333331 143.5L 346.66666666666663 143.5L 520 143.5">
                                                </path>
                                                <path id="SvgjsPath1694"
                                                    d="M 0 61.5C 60.66666666666666 61.5 112.66666666666666 102.5 173.33333333333331 102.5C 233.99999999999997 102.5 286 10.25 346.66666666666663 10.25C 407.3333333333333 10.25 459.3333333333333 41 520 41"
                                                    fill="none" fill-opacity="1" stroke="#28c76f"
                                                    stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                    stroke-dasharray="0" class="apexcharts-area" index="0"
                                                    clip-path="url(#gridRectMaskbl85khoe)"
                                                    pathTo="M 0 61.5C 60.66666666666666 61.5 112.66666666666666 102.5 173.33333333333331 102.5C 233.99999999999997 102.5 286 10.25 346.66666666666663 10.25C 407.3333333333333 10.25 459.3333333333333 41 520 41"
                                                    pathFrom="M -1 143.5L -1 143.5L 173.33333333333331 143.5L 346.66666666666663 143.5L 520 143.5">
                                                </path>
                                                <g id="SvgjsG1687" class="apexcharts-series-markers-wrap"
                                                    data:realIndex="0"></g>
                                            </g>
                                            <g id="SvgjsG1688" class="apexcharts-datalabels" data:realIndex="0"></g>
                                        </g>
                                        <line id="SvgjsLine1714" x1="0" y1="0" x2="520"
                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine1715" x1="0" y1="0" x2="520"
                                            y2="0" stroke-dasharray="0" stroke-width="0"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                        <g id="SvgjsG1716" class="apexcharts-yaxis-annotations"></g>
                                        <g id="SvgjsG1717" class="apexcharts-xaxis-annotations"></g>
                                        <g id="SvgjsG1718" class="apexcharts-point-annotations"></g>
                                    </g>
                                    <rect id="SvgjsRect1681" width="0" height="0" x="0" y="0"
                                        rx="0" ry="0" opacity="1" stroke-width="0"
                                        stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                    <g id="SvgjsG1701" class="apexcharts-yaxis" rel="0"
                                        transform="translate(-18, 0)"></g>
                                    <g id="SvgjsG1679" class="apexcharts-annotations"></g>
                                </svg>
                                <div class="apexcharts-legend" style="max-height: 61.5px;"></div>
                            </div>
                        </div>
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 521px; height: 148px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
