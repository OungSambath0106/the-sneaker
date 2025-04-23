@extends('backends.layouts.admin')
@section('page_title', __('Promotion'))
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
        .carousel-control-prev, .carousel-control-next {
            width: unset !important;
            height: 2rem !important;
            align-self: center !important;
        }
        .carousel-control-prev {
            left: -50px !important;
        }
        .carousel-control-next {
            right: -50px !important;
        }
    </style>
@endpush
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5 class="pb-1">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                                {{ __('Filter') }}
                            </h5>
                        </div>
                        <div class="card-body pt-1">
                            <div class="col-md-12">
                                <div class="tab-content" id="custom-content-below-tabContent">
                                    <form method="GET" action="{{ route('admin.promotion.index') }}">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6">
                                                <label for="discount_type">{{ __('Discount Type') }}</label>
                                                <select name="discount_type" id="discount_type" class="form-control select2">
                                                    <option value="" {{ request('discount_type') == '' ? 'selected' : '' }}>
                                                        {{ __('All Discount Types') }}
                                                    </option>
                                                    <option value="percent" {{ request('discount_type') == 'percent' ? 'selected' : '' }}>
                                                        {{ __('Percent') }}
                                                    </option>
                                                    <option value="amount" {{ request('discount_type') == 'amount' ? 'selected' : '' }}>
                                                        {{ __('Amount') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 filter">
                                                <label for="start_date">{{ __('Start Date') }}</label>
                                                <div class="input-group input-group-alternative">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                    <input type="date" id="start_date" class="form-control flatpickr"
                                                        placeholder="Select Start Date" name="start_date" value="{{ request('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 filter">
                                                <label for="end_date">{{ __('End Date') }}</label>
                                                <div class="input-group input-group-alternative">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                    <input type="date" id="end_date" class="form-control flatpickr"
                                                        placeholder="Select End Date" name="end_date" value="{{ request('end_date') }}">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-end col-lg-12 col-md-12 col-sm-12 mt-4" style="gap: 10px">
                                                <button type="submit" class="btn btn-primary btn-sm mb-0">
                                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                                    {{ __('Filter') }}
                                                </button>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-0"
                                                    id="resetButton">
                                                    <i class="fas fa-sync-alt" id="resetIcon"></i>
                                                    {{ __('Reset') }}
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h5 class="pb-1">{{ __('Promotions Table') }}</h5>
                            @if (auth()->user()->can('promotion.create'))
                                <a class="btn bg-gradient-primary add-new-button-right-side btn-xs" href="{{ route('admin.promotion.create') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    {{ __('Add New') }}
                                </a>
                            @endif
                        </div>
                        <div class="card-body px-3 pt-0 pb-2">
                            <div class="dataTableButtons-container d-flex mx-0 align-items-center pb-2">
                                <div id="dataTableButtons" class="dataTableButtons-left-side col-md-12" style="justify-content: space-between"></div>
                            </div>
                            @include('backends.promotion._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    @include('backends.promotion.partial.delete_promotion_modal')
@endsection
@push('js')
    <script>
        document.getElementById('resetButton').addEventListener('click', function () {
            let icon = document.getElementById('resetIcon');
            icon.classList.add('fa-spin');

            window.location.href = "{{ route('admin.customer.index') }}";
        });
    </script>
    <script>
        function openGalleryModal(promotionId) {
            let modal = new bootstrap.Modal(document.getElementById('imageGalleryModal-' + promotionId), {
                keyboard: true
            });
            modal.show();
        }
    </script>
    <script>
        $(document).ready(function () {
            $('#discount_type').change(function () {
                let discountType = $(this).val();
                let url = new URL(window.location.href);
                url.searchParams.set('discount_type', discountType);
                window.location.href = url.toString();
            });
        });
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

            let promotionId = $(this).data('id');
            let deleteUrl = $(this).data('href');

            $('#deletePromotionModal').data('promotion-id', promotionId).data('delete-url', deleteUrl).modal('show');
        });

        $(document).on('click', '.btn-confirm-modal', function () {
            let modal = $('#deletePromotionModal');
            let promotionId = modal.data('promotion-id');
            let deleteUrl = modal.data('delete-url');

            let row = $(`.btn-delete[data-id="${promotionId}"]`).closest('tr');
            let dataTable = $('#bookingTable').DataTable();

            var data = $(`.form-delete-${promotionId}`).serialize();

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
        initializeStatusInput("{{ route('admin.promotion.update_status') }}");
    </script>
@endpush
