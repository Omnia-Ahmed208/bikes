@extends('layouts.admin.app')

@section('content')

   <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="mb-1">
            {{ __('trans.ads.review') }}
        </h3>

        <div class="nav-align-top mt-3">
            <ul class="nav campaign_tabs" role="tablist">
                <li class="nav-item m-1">
                    <button type="button" class="nav-link d-flex align-items-center shadow-none bg-white border active" data-type="pending"
                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-pending" aria-controls="navs-pills-top-pending" aria-selected="true">
                        {{ __('trans.ads.new') }}
                        <div class="filter_count d-flex align-items-center justify-content-center rounded-circle ms-2 active">
                            @if ($new_campaigns_count > 99)
                                99<i class="ti ti-plus"></i>
                            @else
                                {{ $new_campaigns_count }}
                            @endif
                        </div>
                    </button>
                </li>
                <li class="nav-item m-1">
                    <button type="button" class="nav-link d-flex align-items-center shadow-none bg-white border" data-type="accepted"
                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-accepted" aria-controls="navs-pills-top-accepted" aria-selected="false">
                        {{ __('trans.ads.accepted') }}
                        <div class="filter_count d-flex align-items-center justify-content-center rounded-circle ms-2">
                            @if ($approved_campaigns_count > 99)
                                99<i class="ti ti-plus"></i>
                            @else
                                {{ $approved_campaigns_count }}
                            @endif
                        </div>
                    </button>
                </li>
                <li class="nav-item m-1">
                    <button type="button" class="nav-link d-flex align-items-center shadow-none bg-white border" data-type="rejected"
                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-rejected" aria-controls="navs-pills-top-rejected" aria-selected="false">
                        {{ __('trans.ads.rejected') }}
                        <div class="filter_count d-flex align-items-center justify-content-center rounded-circle ms-2">
                            @if ($not_approved_campaigns_count > 99)
                                99<i class="ti ti-plus"></i>
                            @else
                                {{ $not_approved_campaigns_count }}
                            @endif
                        </div>
                    </button>
                </li>
            </ul>

            <div class="tab-content shadow-none rounded p-0 mt-4" id="table-view">
                <div class="card">
                    <div class="table-header">
                        <div class="filter_section d-flex align-items-center me-2">
                            <form action="{{ route('admin.campaigns.review') }}" method="get" class="mb-0">
                                <a class="filter_icon bg-label-secondary py-2 px-3 rounded" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('backend/img/icons/filter-horizontal.svg') }}" alt="" loading="lazy">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-start p-2 py-0">
                                    <li>
                                        <a class="dropdown-item bg-transparent py-0" href="#">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 py-2">
                                                    <h5 class="fw-semibold d-block text-dark mb-0">{{ __('trans.filter.sort') }}:</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="sort_filter" value="all" checked>
                                            {{ __('trans.filter.all') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="sort_filter" value="name" @if (Request::get('sort_filter') == 'name') checked @endif>
                                            {{ __('trans.filter.name') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="sort_filter" value="latest" @if (Request::get('sort_filter') == 'latest') checked @endif>
                                            {{ __('trans.filter.latest') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="sort_filter" value="oldest" @if (Request::get('sort_filter') == 'oldest') checked @endif>
                                            {{ __('trans.filter.oldest') }}
                                        </a>
                                    </li>

                                    <hr>
                                    <div class="filter_btns d-flex my-2">
                                        <button type="submit" class="btn btn-primary m-1">{{ __('trans.filter.apply') }}</button>
                                        <a href="javascript:void(0);" class="reset_btn btn btn-outline-primary m-1">{{ __('trans.filter.reset') }}</a>
                                    </div>
                                </ul>
                            </form>
                        </div>
                    </div>

                    <div class="card-datatable text-nowrap">
                        <table class="custom_table table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('trans.campaign.media') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.name') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.user_name') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.region') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.bikes_count') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.campaign_duration') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.price') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.date') }}</th>
                                    <th class="text-center">{{ __('trans.campaign.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="rejectCampaignForm" action="" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('trans.ads.reject') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body pt-3 pb-2">
                        <label class="fw-bold" for="rejectNotes">{{ __('trans.ads.notes') }}</label>
                        <textarea id="rejectNotes" class="form-control" name="notes" rows="2" placeholder="{{ __('trans.ads.notes_text') }}"></textarea>
                        {{-- <input type="hidden" id="rejectCampaignId"> --}}
                    </div>

                    <div class="modal-footer justify-content-start pb-2">
                        <button id="submitReject" class="btn btn-primary me-0">{{ __('trans.global.send') }}</button>
                        <button type="button" class="btn btn-label-secondary text-dark me-0" data-bs-dismiss="modal">{{ __('trans.global.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>
        .campaign_tabs .nav-link{border-radius: 16px }
        .campaign_tabs .nav-link.active{
            background: #0077b6 !important;
            border: 1px solid #0077b6 !important;
            color: #fff !important;
        }
        .filter_count{
            background: #0077b6 !important;
            border: 1px solid #0077b6 !important;
            color: #fff !important;
            width: 30px;
            height: 30px;
            font-size: 12px;
            font-weight: bold;
        }
        .filter_count.active{
            background: #fff !important;
            border: 1px solid #fff !important;
            color: #000 !important;
        }
    </style>
@endsection

@push('js')
    <script>
        let selectedStatus = "pending";
        var custom_table = $('.custom_table');

        var table = custom_table.DataTable({
            ajax: {
                url: "{{ route('admin.campaigns.review') }}",
                type: "GET",
                data: function(d) {
                    d.status = selectedStatus;
                    d.sort_filter = $('input[name="sort_filter"]:checked').val();
                },
                dataSrc: function(response) {
                    return response.data;
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            },
            order: [],
            ordering: false,
            columns: [
                { data: 'id' },
                { data: 'file',
                    render: function (data, type, full, meta) {
                        return '';
                        // return `<img src="{{ url('') }}/${data}" class="rounded" width="40" height="40" style="object-fit: cover" loading="lazy">`;
                    }
                },
                { data: 'title' },
                { data: 'user.name' },
                { data: 'region.name' },
                { data: 'bikes_count' },
                { data: 'campaign_duration',
                    render: function (data, type, full, meta) {
                        const translations = {
                            "12_hour": "{{ __('trans.campaign.12_hour') }}",
                            "1_day": "{{ __('trans.campaign.1_day') }}",
                            "3_days": "{{ __('trans.campaign.3_days') }}",
                        };loading="lazy"
                        return translations[data] ?? data;
                    }
                },
                { data: 'price',
                    render: function (data, type, full, meta) {
                        return data + ' <img class="img-fluid mb-1" src="{{ url('') }}/backend/img/sar.png" width="14" height="14" loading="lazy">';
                    }
                },
                { data: 'created_at' },
                { data: null, defaultContent: '' }
            ],
            columnDefs: [
                {
                    targets: -1,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-center justify-content-center gap-2">'+
                                '<a href="/admin/campaigns/' + data.id + '/accept" class="item-accept bg-primary text-white p-2 rounded d-flex align-items-center justify-content-center" style="width: 39px;height: 39px;">'+
                                    '<i class="ti ti-check"></i>'+
                                '</a>'+

                                // open modal
                                '<button class="item-reject-btn rounded p-2 bg-label-secondary d-flex align-items-center justify-content-center border-0 outline-none" data-id="' + data.id + '" style="width: 40px;height: 40px;">'+
                                    '<i class="fa fa-close"></i>'+
                                '</button>'+
                            '</div>'
                        );
                    }
                }
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
            scrollY: false,
            scrollX: true,
            dom: '<"row d-flex flex-wrap justify-content-between align-items-center"<"col-12 col-sm-6 d-flex ms-2"f>>t'+
                '<"row align-items-center"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6 d-flex justify-content-end align-items-center"lp>>',

            initComplete: function() {
                var apiContainer = $(this.api().table().container());
                var searchDiv = apiContainer.find('.dataTables_filter');
                $('.filter_section').insertBefore(searchDiv);

                searchDiv.find('input').css('margin', '0 0 0 10px');
                searchDiv.find('label').contents().filter(function () {
                    return this.nodeType === 3;
                }).remove();

                searchDiv.find('input').attr('placeholder', '{{ __('trans.global.search') }} ...');

                $('.dataTables_filter, .filter_section').css('visibility', 'visible');
            }
        });

        $('.campaign_tabs button').on('click', function() {
            $('.campaign_tabs .filter_count').removeClass('active');
            $(this).find('.filter_count').addClass('active');

            $('.campaign_tabs .nav-link').removeClass('active');
            $(this).addClass('active');

            selectedStatus = $(this).data('type');
            if(selectedStatus != 'pending'){
                table.column(-1).visible(false);
            } else{
                table.column(-1).visible(true);
            }
            table.ajax.reload();
        });

        $('.filter_section form').on('submit', function(e) {
            e.preventDefault();
            table.ajax.reload();
        });

        // reset_btn
        $(document).on('click', '.reset_btn', function(e) {
            e.preventDefault();
            selectedStatus = "pending";
            $('input[name="sort_filter"][value="all"]').prop('checked', true);
            table.ajax.reload();
        });

        $(document).on('click', '.item-reject-btn', function() {
            let id = $(this).data('id');
            // $('#rejectCampaignId').val(id);
            $('#rejectCampaignForm').attr('action', '/admin/campaigns/' + id + '/reject');
            $('#rejectModal').modal('show');
        });

        // $('#submitReject').on('click', function() {
        //     let id = $('#rejectCampaignId').val();
        //     let notes = $('#rejectNotes').val();

        //     $.ajax({
        //         url: '/admin/campaigns/' + id + '/reject',
        //         type: 'POST',
        //         data: {
        //             _token: $('meta[name="csrf-token"]').attr('content'),
        //             notes: notes
        //         },
        //         success: function(response) {
        //             $('#rejectModal').modal('hide');
        //             $('#rejectNotes').val('');

        //             table.ajax.reload(); // refresh table
        //         },
        //         error: function() {
        //             alert('{{ __('trans.alert.error.something_error') }}');
        //         }
        //     });
        // });

    </script>
@endpush
