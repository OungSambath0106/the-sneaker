@extends('backends.master')

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

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>{{ __('Customer Management') }}</h3>
            </div>
            <div class="col-sm-6" style="text-align: right">
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h3 class="card-title"> <i class="fa fa-filter" aria-hidden="true"></i>
                                    {{ __('Filter') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="tab-content" id="custom-content-below-tabContent">
                                <form method="GET" action="{{ route('admin.customer.index') }}">
                                    <div class="row">
                                        <div class=" col-9 d-flex">
                                            <div class="col-sm-6 filter">
                                                <label for="start_date">{{ __('Start Date') }}</label>
                                                <input type="date" id="start_date" class="form-control"
                                                    name="start_date" value="{{ request('start_date') }}">
                                            </div>
                                            <div class="col-sm-6 filter">
                                                <label for="end_date">{{ __('End Date') }}</label>
                                                <input type="date" id="end_date" class="form-control"
                                                    name="end_date" value="{{ request('end_date') }}">
                                            </div>
                                        </div>
                                        <div class=" col-3 mt-3">
                                            <div class="col-sm-12 mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                                    {{ __('Filter') }}
                                                </button>
                                                <a href="{{ route('admin.customer.index') }}"
                                                    class=" btn btn-danger">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                    {{ __('Reset') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h3 class="card-title">{{ __('Customer List') }}</h3>
                            </div>
                            {{-- <span class="badge bg-warning total-count">{{ $grades->total() }}</span> --}}
                            <div class="col-sm-6">
                                {{-- <a href="{{ au }}"></a> --}}
                                @if (auth()->user()->can('customer.create'))
                                <a class="btn btn-primary float-right" href="{{ route('admin.customer.create') }}">
                                    <i class=" fa fa-plus-circle"></i>
                                    {{ __('Add New') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    {{-- table --}}
                    @include('backends.customer._table')

                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

@endsection
@push('js')
<script>
    $('.btn_add').click(function (e) {
        var tbody = $('.tbody');
        var numRows = tbody.find("tr").length;
        $.ajax({
            type: "get",
            url: window.location.href,
            data: {
                "key" : numRows
            },
            dataType: "json",
            success: function (response) {
                $(tbody).append(response.tr);
            }
        });
    });

    $('.custom-file-input').change(function (e) {
        var reader = new FileReader();
        var preview = $(this).closest('.form-group').find('.preview img');
        console.log(preview);
        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();

        const Confirmation = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        Confirmation.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                console.log(`.form-delete-${$(this).data('id')}`);
                var data = $(`.form-delete-${$(this).data('id')}`).serialize();
                // console.log(data);
                $.ajax({
                    type: "post",
                    url: $(this).data('href'),
                    data: data,
                    // dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 1) {
                            $('.table-wrapper').replaceWith(response.view);
                            toastr.success(response.msg);
                        } else {
                            toastr.error(response.msg)

                        }
                    }
                });
            }
        });
    });

    //for update status
    initializeStatusInput("{{ route('admin.customer.update_status') }}");
</script>
@endpush
