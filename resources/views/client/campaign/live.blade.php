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
                <ul class="nav campaign_tabs" role="tablist">
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
                    <a href="javascript:void(0);" class="grid_btn btn bg-white border me-2" data-view="grid">
                        <i class="ti ti-layout-grid fs-3"></i>
                    </a>

                    <a href="javascript:void(0);" class="grid_btn active btn bg-white border me-2" data-view="list">
                        <i class="ti ti-list fs-3"></i>
                    </a>

                    <a href="{{ UrlLang('client/campaigns/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        {{ __('trans.campaign.add_new') }}
                    </a>
                </div>
            </div>

            <div class="tab-content shadow-none p-0 mt-4" id="table-view">
                <div class="card">
                    <div class="table-header">
                        <div class="filter_section d-flex align-items-center me-2">
                            <form action="{{ route('client.campaigns.live') }}" method="get" class="mb-0">
                                <a class="filter_icon bg-label-secondary py-2 px-3 rounded" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('backend/img/icons/filter-horizontal.svg') }}" alt="">
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
                                    <li>
                                        <a class="dropdown-item bg-transparent py-0" href="#">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h5 class="fw-semibold d-block text-dark mb-0">{{ __('trans.campaign.status') }}:</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2" name="status_filter" value="all" checked>
                                            {{ __('trans.filter.all') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="status_filter" value="live" @if (Request::get('status_filter') == 'live') checked @endif>
                                            {{ __('trans.campaign.live') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="status_filter" value="scheduled" @if (Request::get('status_filter') == 'scheduled') checked @endif>
                                            {{ __('trans.campaign.scheduled') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="status_filter" value="finished" @if (Request::get('status_filter') == 'finished') checked @endif>
                                            {{ __('trans.campaign.finished') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-1" href="javascript:void(0);">
                                            <input type="radio" class="form-check-input rounded-circle me-2"
                                            name="status_filter" value="stopped" @if (Request::get('status_filter') == 'stopped') checked @endif>
                                            {{ __('trans.campaign.stopped') }}
                                        </a>
                                    </li>

                                    <hr>
                                    <div class="filter_btns d-flex my-2">
                                        <button type="submit" class="btn btn-primary m-1">{{ __('trans.filter.apply') }}</button>
                                        <a href="{{ route('client.campaigns.live') }}" class="btn btn-outline-primary m-1">{{ __('trans.filter.reset') }}</a>
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
            </div>


            <!-- Grid View -->
            <div class="mt-4" id="grid-view" style="display: none;">
                <div class="row" id="grid-container">
                    <!-- Cards will be populated here -->
                </div>

                <!-- Grid Pagination -->
                <div class="card bg-transparent shadow-none mt-4" id="grid-pagination">
                    <!-- Pagination will be rendered here -->
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
    </style>
@endsection

@push('js')
    <script>
        let selectedStatus = "all";
        let currentView = "list"; // Default view
        let campaignsData = []; // Store campaigns data
        let filterSectionCloned = false; // Track if filter is already in grid view
        let isDataLoading = true; // Track loading state
        let currentPage = 1; // Current page for grid view
        let itemsPerPage = 6; // Items per page for grid view
        var custom_table = $('.custom_table');
        let editRoute = "{{ route('client.campaigns.edit', ':id') }}";

        var table = custom_table.DataTable({
            ajax: {
                url: "{{ route('client.campaigns.live') }}",
                type: "GET",
                data: function(d) {
                    d.status = selectedStatus;
                    d.sort_filter = $('input[name="sort_filter"]:checked').val();
                    d.status_filter = $('input[name="status_filter"]:checked').val();
                },
                dataSrc: function(response) {
                    campaignsData = response.data;
                    isDataLoading = false; // Data loaded successfully

                    if (currentView === 'grid') {
                        renderGridView();
                    }
                    return response.data;
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    isDataLoading = false; // Stop loading even on error
                }
            },
            order: [],
            ordering: false,
            columns: [
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
                            `<span class="rounded-pill badge ${$status[$status_text].class}"
                                style="font-size: 0.8rem; padding: 10px 16px;">
                                ${$status[$status_text].title}
                            </span>`
                        );
                    }
                },
                {
                    targets: -1,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        editUrl = editRoute.replace(':id', full.id);
                        return (
                            '<a href="'+ editUrl +'" class="item-edit text-body">'+
                            '<i class="text-dark bg-label-secondary p-2 mx-1 rounded ti ti-pencil"></i>'+
                            '</a>'+
                            '<a href="javascript:;" class="item-edit text-body">'+
                            '<i class="text-dark bg-label-secondary p-2 mx-1 rounded ti ti-copy"></i>'+
                            '</a>'
                        );
                    }
                },
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

                searchDiv.parent().parent().append(
                    '<a href="javascript:;" class="export_btn btn btn-outline-primary w-auto mx-3">' +
                        '<i class="ti ti-download me-1"></i> {{ __("trans.global.download") }}' +
                    '</a>'
                );

                $('.dataTables_filter, .filter_section').css('visibility', 'visible');
            }
        });

        $('.campaign_tabs button').on('click', function() {
            selectedStatus = $(this).data('type');
            currentPage = 1; // Reset to first page when changing tabs
            isDataLoading = true; // Set loading when reloading data
            table.ajax.reload();
        });

        $(document).on('click', '.export_btn', function (e) {
            e.preventDefault();
            const sort_filter = $('input[name="sort_filter"]:checked').val() ?? 'all';
            const status_filter = $('input[name="status_filter"]:checked').val() ?? 'all';

            let url = `/client/campaigns/export?status=${selectedStatus}&sort_filter=${sort_filter}&status_filter=${status_filter}`;
            window.location.href = url;
        });

        $('.filter_section form').on('submit', function(e) {
            e.preventDefault();
            currentPage = 1; // Reset to first page when filtering
            isDataLoading = true; // Set loading when filtering
            table.ajax.reload();
        });

        // Grid/List Toggle
        $('.grid_btn').on('click', function(e) {
            e.preventDefault();

            // Prevent switching if data is still loading
            if (isDataLoading) {
                // Show a brief notification
                console.log('Please wait for data to load...');
                return;
            }

            $('.grid_btn').removeClass('active');
            $(this).addClass('active');

            currentView = $(this).data('view');

            if (currentView === 'grid') {
                $('#table-view').hide();
                $('#grid-view').show();

                if (!filterSectionCloned) {
                    $('.filter_section').removeClass('me-2');

                    var filterButton = $('.filter_section').find('a[data-bs-toggle="dropdown"]');
                    var campaignTabs = $('.campaign_tabs');

                    // Create wrapper li for filter button only
                    var filterLi = $('<li class="nav-item m-1 filter-li-wrapper d-flex align-items-center"></li>');

                    // Clone and append the entire filter section (form + dropdown)
                    var filterClone = $('.filter_section').clone(true);
                    filterClone.appendTo(filterLi);

                    // Insert as first child of campaign_tabs
                    campaignTabs.prepend(filterLi);

                    filterSectionCloned = true;

                    // bg-label-secondary to bg-white
                    $('.filter_section .filter_icon').removeClass('bg-label-secondary').addClass('bg-white');
                }

                // Hide original filter section
                $('.table-header .filter_section').hide();

                renderGridView();
            } else {
                $('#grid-view').hide();
                $('#table-view').show();

                if (filterSectionCloned) {
                    var filterLi = $('.filter-li-wrapper');
                    filterLi.remove();
                    filterSectionCloned = false;
                }

                $('.table-header .filter_section').show();
                $('.filter_section').addClass('me-2');
                $('.filter_section .filter_icon').removeClass('bg-white').addClass('bg-label-secondary');

                isDataLoading = true; // Set loading when reloading table
                table.ajax.reload();
            }
        });

        // Render Grid View
        function renderGridView() {
            const gridContainer = $('#grid-container');
            gridContainer.empty();

            if (!campaignsData || campaignsData.length === 0) {
                gridContainer.html('<div class="col-12"><p class="text-center">{{ __("trans.global.zero_records") }}</p></div>');
                $('#grid-pagination').hide();
                return;
            }

            // Calculate pagination
            const totalItems = campaignsData.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const currentItems = campaignsData.slice(startIndex, endIndex);

            // Render cards for current page
            currentItems.forEach(function(campaign) {
                const statusBadge = getStatusBadge(campaign.status);
                const imageUrl = "{{ url('') }}/" + campaign.file;
                let editUrl = editRoute.replace(':id', campaign.id);

                const card = `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card shadow-none border mb-2" style="padding: 14px;">
                            <div class="card-body p-0">
                                <div class="img position-relative mb-3">
                                    <img src="${imageUrl}" class="img-fluid rounded w-100" alt="${campaign.title}">
                                    <div class="position-absolute top-0 start-0 badge rounded-pill bg-label-primary m-2">
                                        {{ __('trans.campaign.remaining') }}
                                        (x)
                                        {{ __('trans.campaign.days') }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="title">${campaign.title}</h5>
                                    <div class="status">${statusBadge}</div>
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
                                    <a href="${editUrl}" class="btn btn-primary w-100 me-1">
                                        <i class="ti ti-pencil me-2"></i>
                                        {{ __('trans.global.edit') }}
                                    </a>
                                    <a href="javascript:;" class="btn btn-outline-primary w-100 ms-1">
                                        <i class="ti ti-copy me-2"></i>
                                        {{ __('trans.global.copy') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                gridContainer.append(card);
            });

            // Render pagination
            renderGridPagination(totalPages, totalItems);
        }

        // Get Status Badge
        function getStatusBadge(status) {
            const statusConfig = {
                "live": { title: "{{ __('trans.campaign.live') }}", class: 'bg-label-success' },
                "scheduled": { title: "{{ __('trans.campaign.scheduled') }}", class: 'bg-label-secondary' },
                "finished": { title: "{{ __('trans.campaign.finished') }}", class: 'bg-label-danger' },
                "stopped": { title: "{{ __('trans.campaign.stopped') }}", class: 'bg-label-warning' },
            };

            const config = statusConfig[status] || { title: status, class: 'bg-label-secondary' };
            return `<span class="rounded-pill badge ${config.class}" style="font-size: 0.8rem; padding: 10px 16px;">${config.title}</span>`;
        }

        // Render Grid Pagination
        function renderGridPagination(totalPages, totalItems) {
            const paginationContainer = $('#grid-pagination');
            paginationContainer.empty();

            if (totalPages <= 1) {
                paginationContainer.hide();
                return;
            }

            paginationContainer.show();

            const startItem = ((currentPage - 1) * itemsPerPage) + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);

            let paginationHTML = `
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2">
                            <span>عرض ${startItem} إلى ${endItem} من ${totalItems} نتيجة</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <select class="form-select form-select-sm" id="grid-page-length" style="width: auto;">
                                    <option value="6" ${itemsPerPage === 6 ? 'selected' : ''}>6</option>
                                    <option value="12" ${itemsPerPage === 12 ? 'selected' : ''}>12</option>
                                    <option value="24" ${itemsPerPage === 24 ? 'selected' : ''}>24</option>
                                    <option value="48" ${itemsPerPage === 48 ? 'selected' : ''}>48</option>
                                </select>
                            </div>
                            <ul class="pagination mb-0">
                                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="javascript:void(0);" data-page="${currentPage - 1}">
                                        {{ __('trans.global.previous') }}
                                    </a>
                                </li>
            `;

            // Page numbers
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            if (endPage - startPage < maxVisiblePages - 1) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            if (startPage > 1) {
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" data-page="1">1</a>
                    </li>
                `;
                if (startPage > 2) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" data-page="${totalPages}">${totalPages}</a>
                    </li>
                `;
            }

            paginationHTML += `
                                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                                    <a class="page-link" href="javascript:void(0);" data-page="${currentPage + 1}">
                                        {{ __('trans.global.next') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            `;

            paginationContainer.html(paginationHTML);
        }

        // Handle pagination click
        $(document).on('click', '#grid-pagination .page-link', function(e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) return;

            const page = parseInt($(this).data('page'));
            if (page && page !== currentPage && page > 0) {
                currentPage = page;
                renderGridView();
                // Scroll to top of grid
                $('html, body').animate({
                    scrollTop: $("#grid-view").offset().top - 100
                }, 300);
            }
        });

        // Handle items per page change
        $(document).on('change', '#grid-page-length', function() {
            itemsPerPage = parseInt($(this).val());
            currentPage = 1; // Reset to first page
            renderGridView();
        });

        // Render Grid Pagination
        function renderGridPagination(totalPages, totalItems) {
            const paginationContainer = $('#grid-pagination');
            paginationContainer.empty();

            if (totalPages <= 1) {
                paginationContainer.hide();
                return;
            }

            paginationContainer.show();

            const startItem = ((currentPage - 1) * itemsPerPage) + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);

            let paginationHTML = `
                <div class="d-flex justify-content-center align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <ul class="pagination mb-0">
                            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                <a class="page-link" href="javascript:void(0);" data-page="${currentPage - 1}">
                                    {{ __('trans.global.previous') }}
                                </a>
                            </li>
            `;

            // Page numbers
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            if (endPage - startPage < maxVisiblePages - 1) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            if (startPage > 1) {
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" data-page="1">1</a>
                    </li>
                `;
                if (startPage > 2) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" data-page="${totalPages}">${totalPages}</a>
                    </li>
                `;
            }

            paginationHTML += `
                            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                                <a class="page-link" href="javascript:void(0);" data-page="${currentPage + 1}">
                                    {{ __('trans.global.next') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            `;

            paginationContainer.html(paginationHTML);
        }

        // Handle pagination click
        $(document).on('click', '#grid-pagination .page-link', function(e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) return;

            const page = parseInt($(this).data('page'));
            if (page && page !== currentPage) {
                currentPage = page;
                renderGridView();
                // Scroll to top of grid
                $('html, body').animate({
                    scrollTop: $("#grid-view").offset().top - 100
                }, 300);
            }
        });

        // Handle items per page change
        $(document).on('change', '#grid-page-length', function() {
            itemsPerPage = parseInt($(this).val());
            currentPage = 1; // Reset to first page
            renderGridView();
        });

    </script>
@endpush
