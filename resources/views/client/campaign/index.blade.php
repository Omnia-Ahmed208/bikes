@extends('layouts.client.app')

@section('content')

   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
        @php
            $startYear = \Carbon\Carbon::now()->startOfYear()->format('d-m-Y');
            $endYear = \Carbon\Carbon::now()->endOfYear()->format('d-m-Y');
        @endphp

        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="mb-1">{{ __('trans.campaign.title') }}</h3>

            <div class="d-flex flex-wrap mb-1">
                <div class="position-relative d-flex align-items-center bg-white rounded shadow-sm dateRangeBox me-2">
                    <div class="img bg-primary rounded p-1 m-1">
                        <img src="{{ asset('backend/img/icons/calender.svg') }}" class="img_white" alt="">
                    </div>
                    <input type="text" class="border-0 outline-none dateRange dateRange_total" dir="{{ AppDir() }}"
                    value="{{ $startYear }} to {{ $endYear }}" />
                </div>

                <a href="{{ UrlLang('client/campaigns/create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i>
                    {{ __('trans.campaign.add_new') }}
                </a>
            </div>
        </div>

        <div class="card my-4 shadow-none border">
            <div class="card-body stats-card-body">
                <div class="row stats-first-row">
                    <div class="col-lg-6">
                        <div class="row px-4">
                            <div class="col-6">
                                <h4 class="fw-bold">{{ __('trans.dashboard.total_campaigns') }}</h4>
                                <div class="d-flex align-items-center">
                                    <div class="sm-icons p-3">
                                        <i class="ti ti-ad ti-md"></i>
                                    </div>
                                    <h4 class="fw-bold mx-2 mb-0">
                                        {{ $campaigns_count }}
                                    </h4>
                                    <div class="percentage-{{ $total_campaigns_status }} p-1 px-2 rounded-pill">
                                        {{ $total_campaigns_percentage_abs }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-6" style="justify-items: end">
                                <div id="totalUsersChart" class="text-center"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row px-4">
                            <div class="col-6">
                                <h4 class="fw-bold">{{ __('trans.dashboard.live_campaigns') }}</h4>
                                <div class="d-flex align-items-center">
                                    <div class="sm-icons p-3">
                                        <i class="ti ti-ad ti-md"></i>
                                    </div>
                                    <h4 class="fw-bold mx-2 mb-0">
                                        {{ $live_campaigns_count }}
                                    </h4>
                                    <div class="percentage-success p-1 px-2 rounded-pill">
                                        {{ $live_campaigns_percentage_abs }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-6" style="justify-items: end">
                                <div id="totalUsersChart2" class="text-center"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border-color: #E1E5E8">

                <div class="row stats-second-row">
                    <div class="col-lg-6">
                        <div class="row px-4">
                            <div class="col-6">
                                <h4 class="fw-bold">{{ __('trans.dashboard.scheduled_campaigns') }}</h4>
                                <div class="d-flex align-items-center">
                                    <div class="sm-icons p-3">
                                        <i class="ti ti-ad ti-md"></i>
                                    </div>
                                    <h4 class="fw-bold mx-2 mb-0">
                                        {{ $scheduled_campaigns_count }}
                                    </h4>
                                    <div class="percentage-secondary p-1 px-2 rounded-pill">
                                       {{ $scheduled_campaigns_percentage_abs }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-6" style="justify-items: end">
                                <div id="totalUsersChart3" class="text-center"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row px-4">
                            <div class="col-6">
                                <h4 class="fw-bold">{{ __('trans.dashboard.finished_campaigns') }}</h4>
                                <div class="d-flex align-items-center">
                                    <div class="sm-icons p-3">
                                        <i class="ti ti-ad ti-md"></i>
                                    </div>
                                    <h4 class="fw-bold mx-2 mb-0">
                                        {{ $finished_campaigns_count }}
                                    </h4>
                                    <div class="percentage-danger p-1 px-2 rounded-pill">
                                        {{ $finished_campaigns_percentage_abs }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-6" style="justify-items: end">
                                <div id="totalUsersChart4" class="text-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-none border h-100 mb-4">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="fw-bold mb-1">{{ __('trans.dashboard.expenses_and_capacity') }}</h4>
                            <div>
                                <select name="campaign_period" class="form-select select2 mb-1" id="campaign_period">
                                    <option value="daily">{{ __('trans.dashboard.daily') }}</option>
                                    <option value="weekly" selected>{{ __('trans.dashboard.weekly') }}</option>
                                    <option value="monthly">{{ __('trans.dashboard.monthly') }}</option>
                                    <option value="yearly">{{ __('trans.dashboard.yearly') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <h6 class="fw-bold me-2">{{ __('trans.dashboard.expenses') }}</h6>
                            <h5 class="fw-bold">
                                {{ number_format(50000, 0) }}
                                <img src="{{ asset('backend/img/sar.png') }}" class="mb-2" width="20" alt="currency">
                            </h5>
                        </div>

                        {{-- progress --}}
                        <div class="progress rounded mt-3 mb-2" style="height: 40px">
                            <div class="progress-bar bg-success rounded-start" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar rounded-0" role="progressbar" style="width: 30%; background:#D4D9DC" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-danger rounded-end" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="me-3 d-flex align-items-center text-dark">
                                    <div class="percentage-success-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                                    {{ __('trans.dashboard.live_campaigns') }}:
                                </div>
                                <div class="percent">50%</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="me-3 d-flex align-items-center text-dark">
                                    <div class="percentage-secondary-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                                    {{ __('trans.dashboard.scheduled_campaigns') }}:
                                </div>
                                <div class="percent">30%</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="me-3 d-flex align-items-center text-dark">
                                    <div class="percentage-danger-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                                    {{ __('trans.dashboard.finished_campaigns') }}:
                                </div>
                                <div class="percent">20%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-none border h-100 mb-4">
                    <div class="card-body" style="height: 200px">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold mb-1">{{ __('trans.dashboard.geographical_distribution') }}</h4>
                            <div>
                                <button class="btn btn-outline-secondary text-dark mb-1"> <i class="ti ti-map me-2"></i> {{ __('trans.dashboard.map') }}</button>
                            </div>
                        </div>

                        {{-- <canvas id="adsChart" style="max-height: 200px !important;"></canvas> --}}
                        <canvas id="adsChart" style="display:block;height: 100% !important;padding-bottom: 20px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-none border mb-4 p-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body p-0">
                        <h4>{{ __('trans.dashboard.advertising_campaigns') }}</h4>
                        <p>{{ __('trans.dashboard.advertising_campaigns_desc') }}</p>

                        <div class="d-flex align-items-center mb-2">
                            <div class="xs-icons text-dark p-2">
                                <i class="fa fa-play-circle fa-md"></i>
                            </div>
                            <p class="fw-bold mx-2 mb-0">
                                {{ __('trans.dashboard.time_shown') }}
                            </p>
                            <p class="mb-0">1,245,000</p>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="xs-icons text-dark p-2">
                                <i class="ti ti-clock ti-xs"></i>
                            </div>
                            <p class="fw-bold mx-2 mb-0">
                                {{ __('trans.dashboard.total_duration') }}
                            </p>
                            <p class="mb-0">86 ساعة</p>
                        </div>

                        <div class="alert alert-success">
                            <h5 class="mb-0">
                                <i class="ti ti-check-circle text-success me-2"></i>
                                {{ __('trans.dashboard.general_performance') }}: 80% - {{ __('trans.dashboard.strong_performance') }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <canvas id="campaign_performance"></canvas>
                    <div class="d-flex gap-4">
                        <div class="mx-4 d-flex align-items-center text-dark">
                            <div class="percentage-success-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                            {{ __('trans.dashboard.strong_performance') }}
                        </div>
                            <div class="mx-4 d-flex align-items-center text-dark">
                            <div class="percentage-orange-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                            {{ __('trans.dashboard.good_performance') }}
                        </div>
                            <div class="mx-4 d-flex align-items-center text-dark">
                            <div class="percentage-warning-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                            {{ __('trans.dashboard.average_performance') }}
                        </div>
                            <div class="mx-4 d-flex align-items-center text-dark">
                            <div class="percentage-danger-bg rounded-circle me-1" style="width: 8px; height: 8px"></div>
                            {{ __('trans.dashboard.weak_performance') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-none border">
            <div class="card-header p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="fw-bold mb-1">{{ __('trans.campaign.live_campaign') }}</h4>
                    <a href="{{ UrlLang('client/campaigns/live') }}" class="btn btn-primary text-white mb-1">{{ __('trans.global.view_more') }}</a>
                </div>
            </div>

            <div class="card-body px-0 pt-0">
                <div class="row px-3">
                    @foreach ($campaigns as $item)
                        <div class="col-lg-6">
                            <a href="{{ route('client.campaigns.show', $item->id) }}">
                                <div class="card shadow-none border mb-2" style="padding: 14px;">
                                    <div class="card-body p-0">
                                        <div class="img position-relative mb-3" style="height: 300px;">
                                            <img src="{{ asset($item->file) }}" class="img-fluid w-100 h-100" alt="">

                                            @php
                                                $endDateTime = \Carbon\Carbon::parse($item->end_date . ' ' . $item->end_time);
                                                $remaining = $endDateTime->diffForHumans(now(), [
                                                    'parts' => 2,      // عدد الأجزاء (مثلاً: 5 أيام و 3 ساعات)
                                                    'short' => true,   // صيغة مختصرة
                                                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                                    // 'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                                                ]);

                                                $item->remaining_time = $remaining;
                                            @endphp

                                            @if (!$endDateTime->isPast())
                                                <div class="position-absolute top-0 start-0  badge rounded-pill bg-label-primary m-2">
                                                    {{ __('trans.campaign.remaining') }}
                                                    ({{ $item->remaining_time }})
                                                </div>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="title">{{ $item->title }}</h5>
                                            @if ($item->status == 'live')
                                                <div class="status btn rounded-pill btn-label-success waves-effect">{{ __('trans.campaign.live') }}</div>
                                            @elseif($item->status == 'scheduled')
                                                <div class="status btn rounded-pill btn-label-secondary waves-effect">{{ __('trans.campaign.scheduled') }}</div>
                                            @elseif($item->status == 'finished')
                                                <div class="status btn rounded-pill btn-label-danger waves-effect">{{ __('trans.campaign.finished') }}</div>
                                            @elseif($item->status == 'stopped')
                                                <div class="status btn rounded-pill btn-label-warning waves-effect">{{ __('trans.campaign.stopped') }}</div>
                                            @endif
                                        </div>

                                        <h6 class="mb-0">{{ __('trans.campaign.percentage') }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 4px">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%"
                                                    aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <h6 class="text-nowrap fw-medium mb-0">90%</h6>
                                        </div>

                                        <div class="actions d-flex mt-3">
                                            <a href="{{ route('client.campaigns.edit', $item->id) }}" class="btn btn-primary w-100 me-1">
                                                <i class="ti ti-pencil me-2"></i>
                                                {{ __('trans.global.edit') }}
                                            </a>
                                            <a href="" class="btn btn-outline-primary w-100 ms-1">
                                                <i class="ti ti-copy me-2"></i>
                                                {{ __('trans.global.copy') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
   </div>
    <!-- / Content -->

@endsection


@section('css')
    <link rel="stylesheet" href="{{url('backend')}}/select2/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .dateRange{
            text-align: center !important;
            outline: none;
            height: 37px;
            width: auto;
            color: #000;
            background: transparent;
        }

        .stats-first-row, .stats-second-row {
            position: relative;
        }
        .stats-first-row .col-lg-6:first-child::after,
        .stats-second-row .col-lg-6:first-child::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: 50%; /* نص المسافة بين العمودين */
            width: 1px; /* سمك الخط */
            background-color: #E1E5E8; /* لون الخط */
            transform: translateX(50%); /* لضبطه تمامًا بين العمودين */
        }
    </style>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="{{url('backend')}}/select2/select2.js"></script>
    <script src="{{url('backend')}}/js/percentage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <script>
        halfDoughnutChart(
            [
                '{{ __('trans.dashboard.weak_performance') }}',
                '{{ __('trans.dashboard.average_performance') }}',
                '{{ __('trans.dashboard.good_performance') }}',
                '{{ __('trans.dashboard.strong_performance') }}'
            ]
        );

        $(document).ready(function () {
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            const monthsList = {
                'January': '{{ __('trans.month.january') }}',
                'February': '{{ __('trans.month.february') }}',
                'March': '{{ __('trans.month.march') }}',
                'April': '{{ __('trans.month.april') }}',
                'May': '{{ __('trans.month.may') }}',
                'June': '{{ __('trans.month.june') }}',
                'July': '{{ __('trans.month.july') }}',
                'August': '{{ __('trans.month.august') }}',
                'September': '{{ __('trans.month.september') }}',
                'October': '{{ __('trans.month.october') }}',
                'November': '{{ __('trans.month.november') }}',
                'December': '{{ __('trans.month.december') }}'
            };

            // دالة لتنسيق التاريخ بالعربية
            const formatToArabic = (date) => {
                const day = date.getDate();
                const month = monthsList[date.toLocaleString('en-US', { month: 'long' })];
                const year = date.getFullYear();
                return `${day} ${month} ${year}`;
            };

            // حساب التواريخ الافتراضية (الشهر الحالي والشهر القادم)
            const today = new Date();
            const nextMonth = new Date();
            nextMonth.setMonth(today.getMonth() + 1);

            // تحويل التواريخ إلى الصيغة المطلوبة
            const defaultStartDate = today.toISOString().split('T')[0];
            const defaultEndDate = nextMonth.toISOString().split('T')[0];
            const defaultDisplayText = `${formatToArabic(today)} - ${formatToArabic(nextMonth)}`;

            flatpickr(".dateRange", {
                mode: "range",
                dateFormat: "d-m-Y",
                defaultDate: [defaultStartDate, defaultEndDate],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const startDate = formatToArabic(selectedDates[0]);
                        const endDate = formatToArabic(selectedDates[1]);
                        instance.input.value = `${startDate} - ${endDate}`;
                    }
                },
                onReady: function(selectedDates, dateStr, instance) {
                    // تعيين القيمة الافتراضية بالعربية
                    instance.input.value =  `${formatToArabic(today)} - ${formatToArabic(nextMonth)}`;
                }
            });

            //=========================== charts ===========================
            renderMiniChart("#totalUsersChart", @json($total_campaigns_chart), "#4CAF50");
            renderMiniChart("#totalUsersChart2", @json($live_campaigns_chart), "#4CAF50");
            renderMiniChart("#totalUsersChart3", @json($scheduled_campaigns_chart), "#757575");
            renderMiniChart("#totalUsersChart4", @json($finished_campaigns_chart), "#D32F2F");

            renderBarChart(
                'adsChart',
                @json($country_labels),
                @json($country_campaigns_count),
                '#0077B6',
                @json(AppDir() === 'rtl')
            );

        });
    </script>
@endpush
