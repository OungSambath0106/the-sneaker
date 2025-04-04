<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('SL') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Order ID') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Customer Name') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Total Product Amount	') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Product Discount') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Shipping Charge') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Order Amount') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Payment Method') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Payment Status') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $item)
                <tr>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $loop->iteration }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $item->invoice_ref }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$user->first_name) . ' ' . strtolower(@$user->last_name) }}">
                        <p class="text-sm font-weight-bold mb-0"> {{ $item->customer->first_name }} {{ $item->customer->last_name }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ $item->order_amount }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ $item->discount_amount }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ $item->shipping_fee }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ $item->order_amount }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ ucwords(str_replace('_', ' ', $item->payment_method)) }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ ucwords($item->payment_status) }} </p>
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('admin.order.show', $product->id) }}" class="text-primary font-weight-bold text-xs btn-modal btn-edit pe-1">
                            {{ __('View') }}
                        </a>
                        <button class="btn btn-link text-danger text-sm mb-0 px-0 ms-4">
                            <i class="fas fa-file-pdf text-lg me-1"></i>
                            {{ __('PDF') }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center data-not-available" style="background-color: ghostwhite">
                        {{ __('Transactions are not available.') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
