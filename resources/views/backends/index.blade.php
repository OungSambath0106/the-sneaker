@extends('backends.layouts.admin')
@section('page_title')
    Dashboard
@endsection
@push('css')
    <style>
        .small-box p {
            font-size: 0.9rem;
        }

        .dashboard_event_table tr th {
            background: #d4e0ff !important;
            color: #3d95d0 !important;
            text-transform: uppercase;
        }

        table td {
            height: 75.5px
        }

        .card .card-head-row,
        .card-light .card-head-row {
            display: flex;
            align-items: center;
        }

        .card .card-head-row .card-tools,
        .card-light .card-head-row .card-tools {
            margin-left: auto;
            float: right;
            padding-left: 15px;
        }

        .card-list .item-list {
            display: flex;
            flex-direction: row;
            padding: 10px 0;
            align-items: center;
        }

        .avatar {
            width: 3.2rem;
            height: 3.2rem;
            position: relative;
            display: inline-block;
        }

        .avatar-product {
            width: 4.5rem;
            height: 4.5rem;
            position: relative;
            display: inline-block;
            align-content: center;
        }

        .avatar-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        .card-list .item-list .info-user {
            flex: 1;
            padding-left: 1rem;
        }

        .card-list .item-list .info-user .username,
        .card-list .item-list .info-user a.username {
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .card-list .item-list .info-user .status {
            font-size: 12px;
            color: #7d7b7b;
        }

        .btn-danger {
            color: #F25961 !important;
            background: none !important;
            border: none;
        }

        /* .btn-danger:hover {
                background: none;
            }
            .btn-danger:hover {
                background: none;
            } */
        .avatar .avatar-title {
            font-size: 18px;
        }

        .avatar .border {
            border-width: 3px !important;
        }

        .avatar-title {
            width: 100%;
            height: 100%;
            background-color: #6861CE;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table thead th {
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 24px !important;
            border-bottom-width: 1px;
            font-weight: 600;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th {
            padding: 16px 24px !important;
        }

        .table td,
        .table th {
            font-size: 0.9rem;
            border-bottom: 1px solid;
            border-color: #ebedf2 !important;
            vertical-align: middle !important;
        }

        .btn-icon.btn-sm {
            height: 1.7rem;
            min-width: 1.8rem;
            width: 1.7rem;
        }

        .btn-round {
            border-radius: 100px !important;
        }

        .dashboard_summary_box {
            border-radius: 1rem;
        }
    </style>
@endpush
@section('contents')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ __('Total Users') }}</p>
                                <h5 class="font-weight-bolder">
                                    {{ $users->count() }}
                                </h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+3%</span>
                                    since last week
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ __('Total Brands') }}</p>
                                <h5 class="font-weight-bolder">
                                    {{ $brands->count() }}
                                </h5>
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                    since last quarter
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ __('Total Products') }}</p>
                                <h5 class="font-weight-bolder">
                                    {{ $products->count() }}
                                </h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+55%</span>
                                    since yesterday
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                <h5 class="font-weight-bolder">
                                    $103,430
                                </h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+5%</span> than last
                                    month
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">{{ __('Best Selling Products') }}</h6>
                </div>
                <div class="card-body p-3">
                    @foreach ($count_pro_sale as $pro_sale)
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-md me-3 text-center align-content-center">
                                        @if ($pro_sale->productgallery && count($pro_sale->productgallery->images) > 0)
                                            <div class="custom-carousel carousel-{{ $pro_sale->id }}"
                                                data-product-id="{{ $pro_sale->id }}" data-current-index="0">
                                                @foreach ($pro_sale->productgallery->images as $index => $image)
                                                    <img src="{{ file_exists(public_path('uploads/products/' . $image)) ? asset('uploads/products/' . $image) : asset('uploads/default.png') }}"
                                                        alt="Product Image" class="carousel-image avatar-img"
                                                        style="display: {{ $index == 0 ? 'block' : 'none' }};">
                                                @endforeach
                                            </div>
                                        @else
                                            <img src="{{ !empty($pro_sale->image[0]) && file_exists(public_path('uploads/products/' . $pro_sale->image[0])) ? asset('uploads/products/' . $pro_sale->images[0]) : asset('uploads/default.png') }}"
                                                alt="Product Image" class="avatar-img">
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm"> <a href="{{ route('admin.product.index') }}">
                                                {{ $pro_sale->name }} </a> </h6>
                                        <span class="text-xs">{{ $pro_sale->total_qty }} {{ __('in stock') }}, <span
                                                class="font-weight-bold">{{ $pro_sale->count_product_sale }}
                                                {{ __('sold') }}</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('admin.product.index') }}"
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                        <i class="ni ni-bold-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-carousel overflow-hidden h-100 p-0">
                <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner border-radius-lg h-100">
                        @foreach ($shoesSliders as $index => $shoesSlider)
                            <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}"
                                style="background-image: url('{{ asset('uploads/shoes-slider/' . $shoesSlider->image) }}'); background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <h5 class="text-white mb-1">{{ $shoesSlider->title }}</h5>
                                    <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev w-5 me-3" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next w-5 me-3" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-5 mb-sm-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">{{ __('New Customers') }}</h6>
                </div>
                <div class="card-body p-3">
                    @foreach ($customers as $customer)
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 text-center avatar">
                                        @if ($customer->image && file_exists(public_path('uploads/customers/' . $customer->image)))
                                            <img src="{{ asset('uploads/customers/' . $customer->image) }}" alt="..."
                                                class="avatar-img rounded-circle">
                                        @else
                                            <span class="avatar-title rounded-circle border border-white">
                                                {{ strtoupper(substr($customer->first_name, 0, 1)) }}{{ strtoupper(substr($customer->last_name, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm"> <a
                                                href="{{ route('admin.customer.edit', $customer->id) }}">
                                                {{ $customer->first_name }} {{ $customer->last_name }} </a> </h6>
                                        <span class="text-xs">{{ $customer->email }}</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="d-flex">
                                        <a href="{{ route('admin.customer.index') }}"
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                            <i class="ni ni-bold-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    <span class="text-sm">{{ __('Total') }} {{ $totalCustomers }} {{ __('Customers') }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>{{ __('Transaction History') }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-xs font-weight-bolder opacity-7"> {{ __('Payment Ref') }} </th>
                                    <th class="text-uppercase text-xs font-weight-bolder opacity-7 ps-2"> {{ __('Amount') }} </th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder opacity-7"> {{ __('Status') }} </th>
                                    <th class="opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="py-1">
                                            <div class="d-flex flex-column">
                                                <a href="#" class="mb-1 text-dark font-weight-bold text-sm">December, 15, 2024</a>
                                                <span class="text-xs">#TSK-415646</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$ 180.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">Paid</span>
                                        {{-- <span class="badge badge-sm bg-gradient-secondary">Unpaid</span> --}}
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const carousels = document.querySelectorAll(".custom-carousel");

            carousels.forEach(carousel => {
                const images = carousel.querySelectorAll(".carousel-image");
                let currentIndex = 0;

                carousel.addEventListener("click", function() {
                    images[currentIndex].style.display = "none";

                    currentIndex = (currentIndex + 1) % images.length;

                    images[currentIndex].style.display = "block";
                });
            });
        });
    </script>
@endpush
