@extends('backends.master')
@section('page_title', __('Brand'))
@push('css')
    <style>
        .preview {
            margin-block: 12px;
            text-align: center;
        }

        .tab-pane {
            margin-top: 20px
        }
        .ckbx-style-9 input[type=checkbox]:checked+label:before {
            background: #3d95d0 !important;
            box-shadow: inset 0 1px 1px rgba(84, 116, 152, 0.5) !important;
        }
    </style>
@endpush
@section('contents')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <fieldset class="border fieldset-table px-3 mb-4">
                        <legend class="w-auto mb-0 pb-0 title-table text-uppercase">{{ __('Brand List') }}</legend>
                        <div class="card-header pt-2 px-0">
                            <div class="row mx-0 align-items-center" style="justify-content: space-between">
                                <div id="dataTableButtons" class="col-md-10" style="justify-content: space-between"></div>
                                @if (auth()->user()->can('brand.create'))
                                    <a class="btn btn-primary btn-modal" href="#" data-href="{{ route('admin.brand.create') }}"
                                        data-toggle="modal" data-container=".modal_form">
                                        <i class="fas fa-plus-circle"></i>
                                        {{ __('Add New') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        @include('backends.brand._table')
                    </fieldset>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center position-relative">
                    {{-- <button type="button" class="close position-absolute" style="right: 3px; top: 0; color: red;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <img id="modalImage" src="" alt="User Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection
@push('js')
    <script>
        function showImageModal(img) {
            document.getElementById('modalImage').src = img.src;
        }
    </script>
    <script>
        $('.btn_add').click(function(e) {
            var tbody = $('.tbody');
            var numRows = tbody.find("tr").length;
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    $(tbody).append(response.tr);
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            $("div.modal_form").load($(this).data('href'), function() {

                $(this).modal('show');

            });
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            let brandId = $(this).data('id');
            let deleteUrl = $(this).data('href');

            $('#deleteBrandModal').data('brand-id', brandId).data('delete-url', deleteUrl).modal('show');
        });

        $(document).on('click', '.btn-confirm-modal', function () {
            let modal = $('#deleteBrandModal');
            let brandId = modal.data('brand-id');
            let deleteUrl = modal.data('delete-url');

            let row = $(`.btn-delete[data-id="${brandId}"]`).closest('tr');
            let dataTable = $('#bookingTable').DataTable();

            var data = $(`.form-delete-${brandId}`).serialize();

            $.ajax({
                type: "POST",
                url: deleteUrl,
                data: data,
                success: function (response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    if (response.success == 1) {
                        dataTable.row(row).remove().draw(false);
                        modal.modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.msg
                        });
                    }
                }
            });
        });

        //for update status
        initializeStatusInput("{{ route('admin.brand.update_status') }}");
    </script>
@endpush
