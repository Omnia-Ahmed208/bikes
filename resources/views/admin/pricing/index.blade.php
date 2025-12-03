@extends('layouts.admin.app')

@section('content')

   <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="mb-1">
            {{ __('trans.ads.review') }}
        </h3>

        <div class="card">
            <div class="card-datatable text-nowrap">
                <table class="custom_table table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('trans.pricing.country') }}</th>
                            <th class="text-center">{{ __('trans.pricing.region') }}</th>
                            <th class="text-center">{{ __('trans.pricing.price') }}</th>
                            <th class="text-center">{{ __('trans.pricing.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        var custom_table = $('.custom_table');

        var table = custom_table.DataTable({
            ajax: {
                url: "{{ route('admin.campaigns-pricing.index') }}",
                type: "GET",
            },
            order: [],
            ordering: false,
            columns: [
                { data: 'id' },
                { data: 'country.name' },
                { data: 'region.name' },
                { data: 'price',
                    render: function (data, type, full, meta) {
                        return data + ' <img class="img-fluid mb-1" src="{{ url('') }}/backend/img/sar.png" width="14" height="14" loading="lazy">';
                    }
                },
                { data: null, defaultContent: '' }
            ],
            columnDefs: [
                {
                    targets: -1,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<a href="campaigns-pricing/'+ data.id +'/edit" class="item-edit text-body">'+
                            '<i class="text-dark bg-label-secondary p-2 mx-1 rounded ti ti-pencil"></i>'+
                            '</a>'
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

                searchDiv.find('input').css('margin', '0 0 0 10px');
                searchDiv.find('label').contents().filter(function () {
                    return this.nodeType === 3;
                }).remove();

                searchDiv.find('input').attr('placeholder', '{{ __('trans.global.search') }} ...');

                searchDiv.parent().parent().append(
                    '<a href="campaigns-pricing/create" class="btn btn-primary w-auto mx-3">' +
                        '<i class="ti ti-plus me-1"></i> {{ __("trans.pricing.add_new") }}' +
                    '</a>'
                );
                
                $('.dataTables_filter').css('visibility', 'visible');
            }
        });
    </script>
@endpush
