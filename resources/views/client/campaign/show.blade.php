@extends('layouts.client.app')

@section('content')

   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <a href="{{ UrlLang('client/campaigns') }}">
                <i class="ti ti-arrow-{{ AppLang() == 'ar' ? 'right' : 'left' }} fw-bold text-dark"></i>
            </a>

            <div class="d-flex">
                <a href="{{ route('client.campaigns.edit', $campaign->id) }}" class="btn btn-primary w-100 me-1">
                    <i class="ti ti-pencil me-2"></i>
                    {{ __('trans.global.edit') }}
                </a>
                <a href="" class="btn btn-outline-primary w-100 ms-1">
                    <i class="ti ti-copy me-2"></i>
                    {{ __('trans.global.copy') }}
                </a>
            </div>
        </div>

        <div class="card shadow-none border mb-2" style="padding: 14px;">
            <div class="card-body p-0">
                <div class="img position-relative mb-3" style="height: 500px;">
                    <img src="{{ asset($campaign->file) }}" class="img-fluid w-100 h-100" alt="">

                    @php
                        $endDateTime = \Carbon\Carbon::parse($campaign->end_date . ' ' . $campaign->end_time);
                        $remaining = $endDateTime->diffForHumans(now(), [
                            'parts' => 2,      // عدد الأجزاء (مثلاً: 5 أيام و 3 ساعات)
                            'short' => true,   // صيغة مختصرة
                            'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                            // 'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                        ]);

                        $campaign->remaining_time = $remaining;
                    @endphp

                    @if (!$endDateTime->isPast())
                        <div class="position-absolute top-0 start-0 badge rounded-pill bg-label-primary m-2">
                            {{ __('trans.campaign.remaining') }}
                            ({{ $campaign->remaining_time }})
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="title">{{ $campaign->title }}</h5>
                    @if ($campaign->status == 'live')
                        <div class="status btn rounded-pill btn-label-success waves-effect">{{ __('trans.campaign.live') }}</div>
                    @elseif($campaign->status == 'scheduled')
                        <div class="status btn rounded-pill btn-label-secondary waves-effect">{{ __('trans.campaign.scheduled') }}</div>
                    @elseif($campaign->status == 'finished')
                        <div class="status btn rounded-pill btn-label-danger waves-effect">{{ __('trans.campaign.finished') }}</div>
                    @elseif($campaign->status == 'stopped')
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

                <div class="bg-label-secondary rounded mt-3 px-2 pt-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <p class="text-center fw-bold mb-2">{{ __('trans.campaign.duration') }}</p>
                            <h6 class="text-center mb-0">
                                {{ $campaign->media_duration }} {{ __('trans.campaign.second') }}
                            </h6>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <p class="text-center fw-bold mb-2">{{ __('trans.campaign.campaign_duration') }}</p>
                            <h6 class="text-center mb-0">
                                @if ($campaign->campaign_duration == '12_hour' )
                                    {{ __('trans.campaign.12_hour') }}
                                @elseif($campaign->campaign_duration == '1_day' )
                                    {{ __('trans.campaign.1_day') }}
                                @elseif($campaign->campaign_duration == '3_days' )
                                    {{ __('trans.campaign.3_days') }}
                                @endif
                            </h6>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <p class="text-center fw-bold mb-2">{{ __('trans.campaign.region') }}</p>
                            <h6 class="text-center mb-0">
                                {{ $campaign->region->name }}
                            </h6>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <p class="text-center fw-bold mb-2">{{ __('trans.campaign.bikes_count') }}</p>
                            <h6 class="text-center mb-0">
                                {{ $campaign->bikes_count }}
                            </h6>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <p class="text-center fw-bold mb-2">{{ __('trans.campaign.price') }}</p>
                            <h6 class="text-center mb-0">
                                {{ number_format($campaign->price, 0) }}
                                <img src="{{ asset('backend/img/sar.png') }}" class="mb-2" width="20" alt="currency">
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border my-4 p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-body p-0">
                                <h4>{{ __('trans.dashboard.advertising_campaigns') }}</h4>
                                <p>{{ __('trans.dashboard.advertising_campaigns_desc') }}</p>

                                <div class="d-flex align-items-center mb-2">
                                    <div class="xs-icons text-dark p-2">
                                        <i class="ti ti-clock ti-xs"></i>
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
                    </div>
                </div>

                <div class="tab-content shadow-none p-0 mt-4 border" id="table-view">
                    <div class="card">
                        <div class="card-datatable text-nowrap">
                            <table class="custom_table table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('trans.campaign.duration') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.status') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.date') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.execution_percentage') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>{{ $campaign->campaign_duration }}</td>
                                        <td>{{ $campaign->status }}</td>
                                        <td>{{ $campaign->created_at }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
   </div>

@endsection



@push('js')
    <script>
        var custom_table = $('.custom_table');

        var table = custom_table.DataTable({
            language: {
                lengthMenu: "{{ __('trans.global.lengthMenu') }}",
                zeroRecords: "{{ __('trans.global.zero_records') }}",
                infoEmpty: "{{ __('trans.global.info_empty') }}",
                infoFiltered: "(تمت تصفية _MAX_ سجلات)",
                search: "{{ __('trans.global.search') }}:",
                loadingRecords: "{{ __('trans.global.search') }}...",
                info: "{{ __('trans.global.info_filtered') }}",
                emptyTable: "{{ __('trans.global.info_empty') }}",
                paginate: {
                    next: "{{ __('trans.global.next') }}",
                    previous: "{{ __('trans.global.previous') }}"
                }
            },
            // Scroll options
            scrollY: false,
            scrollX: true,
            dom: '<"row d-flex flex-wrap justify-content-between align-items-center"<"col-12 col-sm-6 d-flex ms-2"f>>t'+
                '<"row align-items-center"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6 d-flex justify-content-end align-items-center"lp>>',

            initComplete: function() {
                // export btn
                var searchInput = $(this.api().table().container()).find('div.dataTables_filter');
                searchInput.find('input').css('margin', '0 0 0 10px');
                searchInput.find('label').contents().filter(function () {
                    return this.nodeType === 3;
                }).remove();

                searchInput.find('input').attr('placeholder', '{{ __('trans.global.search') }} ...');

                // parent div of searchinput => searchInput.parent().parent().append('<a href="javascript:;" class="btn btn-sm btn-primary ms-2"> <i class="ti ti-download me-1"></i> Export</a>');
                searchInput.parent().parent().append(
                    '<a href="javascript:;" class="export_btn btn btn-outline-primary w-auto mx-3">' +
                        '<i class="ti ti-download me-1"></i> {{ __("trans.global.download") }}' +
                    '</a>'
                );

            }
        });

    </script>
@endpush

