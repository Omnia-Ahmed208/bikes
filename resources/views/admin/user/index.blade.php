@extends('layouts.admin.app')

@section('content')

   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h5 class="text-md-start text-center">{{ __('trans.user.title') }}</h5>
            <a  href="{{ route('admin.users.create') }}" class="btn btn-primary w-auto">{{ __('trans.user.add_new') }}</a>
        </div>

        <div class="card">
            <div class="card-body pt-2 pb-0">
                <div class="table-responsive text-nowrap">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: justify">#</th>
                                <th style="text-align: justify">{{ __('trans.auth.name') }}</th>
                                <th style="text-align: justify">{{ __('trans.auth.email') }}</th>
                                <th style="text-align: justify">{{ __('trans.global.created_at') }}</th>
                                <th style="text-align: justify">{{ __('trans.global.details') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th style="text-align: justify">#</th>
                                <th style="text-align: justify">{{ __('trans.auth.name') }}</th>
                                <th style="text-align: justify">{{ __('trans.auth.email') }}</th>
                                <th style="text-align: justify">{{ __('trans.global.created_at') }}</th>
                                <th style="text-align: justify">{{ __('trans.global.details') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- / Content -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let table = new DataTable('#example', {
                ajax: {
                    url: "{{ route('admin.users.index') }}",
                    type: "GET",
                    dataSrc: function(response) {
                        return response.data;
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText);
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: null, name: 'details' }
                ],
                order: [[0, 'desc']],
                columnDefs: [
                    {
                        targets: 4,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `
                                <a href="{{ url('/admin/users/') }}/${row.id}" class="btn btn-sm btn-secondary rounded mb-1">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="{{ url('/admin/users/') }}/${row.id}/edit" class="btn btn-sm btn-info rounded mb-1">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ url('/admin/users/') }}/${row.id}" method="post" class="delete-form d-inline">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-sm btn-danger rounded btn-delete mb-1"
                                    data-confirm="{{ __('trans.alert.are_you_sure') }}">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            `;
                        }
                    }
                ],
                dom: "<'row my-4'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row my-4'<'col-sm-5'i><'col-sm-7 d-flex justify-content-end'p>>",
                language: {
                    emptyTable: "لا توجد بيانات في الجدول",
                    lengthMenu: "عرض _MENU_ سجل لكل صفحة",
                    zeroRecords: "لم يتم العثور على بيانات",
                    infoEmpty: "لا توجد بيانات متاحة",
                    infoFiltered: "(تمت تصفية _MAX_ سجلات)",
                    search: "بحث:",
                }
            });

            document.addEventListener("click", function(event) {
                if (event.target.closest(".btn-delete")) {
                    event.preventDefault();

                    let button = event.target.closest(".btn-delete");
                    let confirmMessage = button.getAttribute("data-confirm") || "{{ __('trans.alert.are_you_sure') }}";

                    if (confirm(confirmMessage)) {
                        button.closest("form").submit();
                    }
                }
            });
        });
    </script>
@endsection
