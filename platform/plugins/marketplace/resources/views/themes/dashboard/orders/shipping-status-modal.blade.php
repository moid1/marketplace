{!! Form::open(['url' => $url]) !!}

<div class="form-group">
    <label for="shipment-status" class="control-label">{{ trans('plugins/ecommerce::shipping.status') }}</label>
    {!! Form::customSelect(
    'status',
    [
        \Botble\Ecommerce\Enums\ShippingStatusEnum::ARRANGE_SHIPMENT => \Botble\Ecommerce\Enums\ShippingStatusEnum::ARRANGE_SHIPMENT()->label(),
        \Botble\Ecommerce\Enums\ShippingStatusEnum::READY_TO_BE_SHIPPED_OUT => \Botble\Ecommerce\Enums\ShippingStatusEnum::READY_TO_BE_SHIPPED_OUT()->label(),
        \Botble\Ecommerce\Enums\ShippingStatusEnum::DELIVERED => 'Shipped',
    ],
    $shipment->status,
) !!}
    <label for="shipping_agent" class="control-label">{{ trans('Shipping Service') }}</label>

    {!! Form::customSelect('shipping_company_name', ['FedX', 'USP', 'USPS'], $shipment->shipping_company_name) !!}
    <label for="tracking_id" class="control-label">{{ trans('plugins/ecommerce::shipping.tracking_id') }}</label>
    <input type="text" name="tracking_id" id="tracking_id" value="{{ $shipment->tracking_id }}" class="form-control" placeholder="Ex: JJD0099999999"></div>

{!! Form::close() !!}
