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

        <div class="row m-0 mt-4">
            {{-- <div class="col-lg-6 mb-4">
                <div class="card h-100 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">{{ __('trans.statistics.consultations') }}</h5>
                            <div>
                                <select name="consultations_users_type" class="form-select select2" id="consultations_users_type">
                                    <option value="doctors">{{ __('trans.statistics.doctors') }}</option>
                                    <option value="patients">{{ __('trans.statistics.patients') }}</option>
                                </select>
                            </div>
                        </div>

                        <canvas id="adsChart" style="max-height: 340px !important;"></canvas>
                    </div>
                </div>
            </div> --}}

            <div class="card">
                <div class="card-header p-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="fw-bold mb-1">{{ __('trans.campaign.live_campaign') }}</h5>
                        <a class="btn btn-primary text-white mb-1">{{ __('trans.global.view_more') }}</a>
                    </div>
                </div>

                <div class="card-body px-0 pt-0">
                    <div class="row px-3">
                        <div class="col-lg-6">
                            <div class="card shadow-none border mb-2" style="padding: 14px;">
                                <div class="card-body p-0">
                                    <div class="img position-relative mb-3">
                                        <img src="{{ url('backend/img/motocycle_orange.png') }}"
                                        class="img-fluid w-100" alt="">

                                        <div class="position-absolute top-0 start-0  badge rounded-pill bg-label-primary m-2">
                                            {{ __('trans.campaign.remaining') }}
                                            (x)
                                            {{ __('trans.campaign.days') }}
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="title">{{ __('trans.campaign.name') }}</h5>
                                        <div class="status btn rounded-pill btn-label-success waves-effect">{{ __('trans.campaign.live') }}</div>
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
                                        <a href="" class="btn btn-primary w-100 me-1">
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
                        </div>

                        <div class="col-lg-6">
                            <div class="card shadow-none border mb-2" style="padding: 14px">
                                <div class="card-body p-0">
                                    <div class="img position-relative mb-3">
                                        <img src="{{ url('backend/img/food_delivery.png') }}"
                                        class="img-fluid w-100" alt="">

                                        <div class="position-absolute top-0 start-0  badge rounded-pill bg-label-primary m-2">
                                            {{ __('trans.campaign.remaining') }}
                                            (x)
                                            {{ __('trans.campaign.days') }}
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="title">{{ __('trans.campaign.name') }}</h5>
                                        <div class="status btn rounded-pill btn-label-warning waves-effect">
                                            {{ __('trans.campaign.stopped') }}
                                        </div>
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
                                        <a href="" class="btn btn-primary w-100 me-1">
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
                        </div>
                    </div>
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
    </style>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{url('backend')}}/select2/select2.js"></script>
    <script src="{{url('backend')}}/js/percentage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
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


            renderBarChart(
                'adsChart',
                ['ads_1', 'ads_2', 'ads_3'],
                [10, 20, 30],
                '#3563AD',
                @json(AppDir() === 'rtl')
            );

        });
    </script>
@endpush
