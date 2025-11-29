@extends('layouts.client.app')

@section('content')

   <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <a href="{{ UrlLang('client/campaigns') }}">
                <h3 class="mb-1">
                <i class="ti ti-arrow-{{ AppLang() == 'ar' ? 'right' : 'left' }} fw-bold"></i>
                {{ __('trans.campaign.live_campaign') }}
            </h3>
        </a>

        <div class="nav-align-top mt-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <ul class="nav nav- campaign_tabs" role="tablist">
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border active" data-type="all"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-all" aria-controls="navs-pills-top-all" aria-selected="true">
                            {{ __('trans.global.all') }}
                        </button>
                    </li>
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border" data-type="live"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-live" aria-controls="navs-pills-top-live" aria-selected="false">
                            {{ __('trans.campaign.live_campaign') }}
                        </button>
                    </li>
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border" data-type="scheduled"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-scheduled" aria-controls="navs-pills-top-scheduled" aria-selected="false">
                            {{ __('trans.campaign.scheduled_campaign') }}
                        </button>
                    </li>
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border" data-type="finished"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-finished" aria-controls="navs-pills-top-finished" aria-selected="false">
                            {{ __('trans.campaign.finished_campaign') }}
                        </button>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="grid_btn btn bg-white border me-2">
                        <i class="ti ti-layout-grid fs-3"></i>
                    </a>

                    <a href="javascript:void(0);" class="grid_btn active btn bg-white border me-2">
                        <i class="ti ti-list fs-3"></i>
                    </a>

                    <a href="{{ UrlLang('client/campaigns/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        {{ __('trans.campaign.add_new') }}
                    </a>
                </div>
            </div>

            <div class="tab-content shadow-none p-0 mt-4">
                {{-- <div class="tab-pane fade active show" id="navs-pills-top-all" role="tabpanel"> --}}
                    <div class="card">
                        
                        <div class="card-datatable text-nowrap">
                            <table class="custom_table table">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center"></th> --}}
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('trans.campaign.media') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.name') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.region') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.bikes_count') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.campaign_duration') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.price') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.status') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.date') }}</th>
                                        <th class="text-center">{{ __('trans.campaign.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                {{-- </div> --}}

                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('css')
    <style>
        .campaign_tabs .nav-link.active{
            background: #0077b6 !important;
            border: 1px solid #0077b6 !important;
            color: #fff !important;
        }

        .grid_btn{
            width: 50px;
            height: 40px;
            color: #000;
        }
        .grid_btn.active{
            border: 1px solid #0077b6 !important;
            color: #0077b6 !important;
        }

        .dataTables_scrollBody{
            max-height: auto !important;
            height: auto !important;
        }

        .dataTables_length{margin: 0 !important; font-size: 14px !important;}
        select[name="DataTables_Table_0_length"]{padding: 0 0 0 30px !important; border: 0; box-shadow: none !important;}
        @media (max-width: 575.98px) {
            .col-sm-12.col-md-6:has(#DataTables_Table_0_length){flex-wrap: wrap; justify-content: center !important;}

            /* [dir=rtl] div.dataTables_wrapper .dataTables_filter{text-align-last: start} */
            [dir=rtl] div.dataTables_wrapper .dataTables_filter input{margin: 0; display: block; width: 95%}
        }
    </style>
@endsection

@push('js')
    <script>
        let selectedStatus = "all";
        var custom_table = $('.custom_table');

        var table = custom_table.DataTable({
            ajax: {
                url: "{{ route('client.campaigns.live') }}",
                type: "GET",
                data: function(d) {
                    d.status = selectedStatus;
                },
                dataSrc: function(response) {
                    return response.data;
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                // { data: 'id' },
                { data: 'id' },
                { data: 'file',
                    render: function (data, type, full, meta) {
                        return `<img src="{{ url('') }}/${data}" class="rounded" width="40" height="40">`;
                    }
                },
                { data: 'title' },
                { data: 'region.name' },
                { data: 'bikes_count' },
                { data: 'campaign_duration',
                    render: function (data, type, full, meta) {
                        const translations = {
                            "12_hour": "{{ __('trans.campaign.12_hour') }}",
                            "1_day": "{{ __('trans.campaign.1_day') }}",
                            "3_days": "{{ __('trans.campaign.3_days') }}",
                        };
                        return translations[data] ?? data;
                    }
                },
                { data: 'price',
                    render: function (data, type, full, meta) {
                        return data + ' <img class="img-fluid mb-1" src="{{ url('') }}/backend/img/sar.png" width="14" height="14">';
                    }
                },
                { data: 'status' },
                { data: 'created_at' },
                { data: null, defaultContent: '' }
            ],
            columnDefs: [
                {
                    // status
                    targets: -3,
                    render: function (data, type, full, meta) {
                        var $status_text = full['status'];
                        var $status = {
                            "live": { title: "{{ __('trans.campaign.live') }}", class: 'bg-label-success' },
                            "scheduled": { title: "{{ __('trans.campaign.scheduled') }}", class: ' bg-label-secondary' },
                            "finished": { title: "{{ __('trans.campaign.finished') }}", class: ' bg-label-danger' },
                            "stopped": { title: "{{ __('trans.campaign.stopped') }}", class: ' bg-label-warning' },
                        };
                        if (typeof $status[$status_text] === 'undefined') {
                            return data;
                        }
                        return (
                            // '<span class="rounded-pill badge ' + $status[$status_text].class + '">' + $status[$status_text].title + '</span>'
                            `<span class="rounded-pill badge ${$status[$status_text].class}"
                                style="font-size: 0.8rem; padding: 10px 16px;">
                                ${$status[$status_text].title}
                            </span>`
                        );
                    }
                },
                {
                    // Actions
                    targets: -1,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<a href="javascript:;" class="item-edit text-body">'+
                            '<i class="text-dark bg-label-secondary p-2 mx-1 rounded ti ti-pencil"></i>'+
                            '</a>'+
                            '<a href="javascript:;" class="item-edit text-body">'+
                            '<i class="text-dark bg-label-secondary p-2 mx-1 rounded ti ti-copy"></i>'+
                            '</a>'
                        );
                    }
                },
                // {
                //     // For Checkboxes
                //     targets: 0,
                //     searchable: false,
                //     orderable: false,
                //     render: function () {
                //         return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                //     },
                //     checkboxes: {
                //         selectRow: false,
                //         selectAllRender: '<input type="checkbox" class="form-check-input">'
                //     }
                // },
            ],
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

        $('.campaign_tabs button').on('click', function() {
            selectedStatus = $(this).data('type'); // get data-type of button
            table.ajax.reload();
        });

        // event delegation for dynamic button
        $(document).on('click', '.export_btn', function (e) {
            e.preventDefault();

            // const status_filter = $('input[name="testResult_status_filter"]:checked').val() ?? 'all';
            // const sort_filter = $('input[name="testResult_sort_filter"]:checked').val() ?? 'all';
            // const search = $('#searchTestResultInput').val();

            // Example export call:
            // const url = `/doctor/patients/${patient_id}/medical-tests/export?status_filter=${status_filter}&sort_filter=${sort_filter}&search=${search}`;
            let url = `/client/campaigns/export?status=${selectedStatus}`;
            window.location.href = url;
        });

        // Filter form submission
        $('.filter_section form').on('submit', function(e) {
            e.preventDefault();
            table.ajax.reload();
        });

    </script>
@endpush
