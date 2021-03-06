<div class="order-customer-info">
    <h3> {{ __('Customer information') }}</h3>
    <p>
        <span class="d-inline-block">{{ __('Full name') }}:</span>
        <span class="order-customer-info-meta">{{ $order->address->name }}</span>
    </p>
    @if ($order->address->phone)
        <p>
            <span class="d-inline-block">{{ __('Phone') }}:</span>
            <span class="order-customer-info-meta">{{ $order->address->phone }}</span>
        </p>
    @endif
    <p>
        <span class="d-inline-block">{{ __('Email') }}:</span>
        <span class="order-customer-info-meta">{{ $order->address->email }}</span>
    </p>
    <p>
        <span class="d-inline-block">{{ __('Address') }}:</span>
        <span class="order-customer-info-meta">{{ $order->full_address }}</span>
    </p>
    <p>
        <span class="d-inline-block">{{ __('Shipping method') }}:</span>
        <span class="order-customer-info-meta">{{ $order->shipping_method_name }} -
            {{ format_price($order->shipping_amount) }}</span>
    </p>
    <p>
        <span class="d-inline-block">{{ __('Payment method') }}:</span>
        <span class="order-customer-info-meta">{{ $order->payment->payment_channel->label() }}</span>
    </p>
    <p>
        <span class="d-inline-block">{{ __('Payment status') }}:</span>
        <span class="order-customer-info-meta" style="text-transform: uppercase">{!! $order->payment->status->toHtml() !!}</span>
    </p>

    @if ($order->payment->payment_channel == 'crypto')
        <p>
            <span class="d-inline-block">{{ __('Crypto Total') }}:</span>
            <span class="order-customer-info-meta" style="text-transform: uppercase">{!! $order->payment->crypto_payment !!}</span>
        </p>
    @endif

</div>
@if ($order->payment->payment_channel == 'crypto')
    <div class="col-md-6 checkout-button-group">
        <button class="btn payment-checkout-btn payment-checkout-btn-step float-end"> Make Payment </button>
    </div>
@endif

<script>
    $(document).off('click', '.payment-checkout-btn-step').on('click', '.payment-checkout-btn-step', function(event) {
        event.preventDefault();
        var order = @json($order);
        var settings = {
            "url": "https://api.nowpayments.io/v1/invoice",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "x-api-key": "7R5W2YB-8YA4WHK-GPH5ANG-Y4PCHXX",
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "price_amount": order.amount,
                "price_currency": order.payment.currency,
                "order_id": $('.order-code').find('span').text().trim(),
                "ipn_callback_url": window.location.origin + "/api/payment",
                "success_url": window.location.origin + "/customer/orders/view/" + order.id,
                "cancel_url": window.location.origin
            }),
        };

        $.ajax(settings).done(function(response) {
            window.location.href = response.invoice_url;
        });

    });
</script>
