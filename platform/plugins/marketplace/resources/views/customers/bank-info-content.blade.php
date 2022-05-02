<div class="tab-pane" id="tab_bank_info">
    <div class="form-group">
        <div class="ps-form__content">
            <div class="form-group">
                <label for="bank_info_name">{{ __('Bank Name') }}:</label>
                <input id="bank_info_name"
                    type="text"
                    class="form-control"
                    name="bank_info[name]"
                    placeholder="{{ __('Bank Name') }}"
                    value="{{ Arr::get($model->bank_info, 'name') }}">
            </div>
            {!! Form::error('bank_info[name]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_code">{{ __('Bank Code/IFSC') }}:</label>
                <input id="bank_info_code"
                    type="text"
                    class="form-control"
                    name="bank_info[code]"
                    placeholder="{{ __('Bank Code/IFSC') }}"
                    value="{{ Arr::get($model->bank_info, 'code') }}">
            </div>
            {!! Form::error('bank_info[code]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_number">{{ __('Account Number') }}:</label>
                <input id="bank_info_number"
                    type="text"
                    class="form-control"
                    placeholder="{{ __('Bank number') }}"
                    name="bank_info[number]"
                    value="{{ Arr::get($model->bank_info, 'number') }}">
            </div>
            {!! Form::error('bank_info[number]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_full_name">{{ __('Account Holder Name') }}:</label>
                <input id="bank_info_full_name"
                    type="text"
                    class="form-control"
                    placeholder="{{ __('Full name') }}"
                    name="bank_info[full_name]"
                    value="{{ Arr::get($model->bank_info, 'full_name') }}">
            </div>
            {!! Form::error('bank_info[full_name]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_paypal_id">{{ __('PayPal ID') }}:</label>
                <input id="bank_info_paypal_id"
                    type="text"
                    class="form-control"
                    placeholder="{{ __('PayPal ID') }}"
                    name="bank_info[paypal_id]"
                    value="{{ Arr::get($model->bank_info, 'paypal_id') }}">
            </div>
            {!! Form::error('bank_info[paypal_id]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_cryto_wallet">{{ __('Crypto Wallet Address') }}:</label>
                <input id="bank_info_crypto_wallet"
                    type="text"
                    class="form-control"
                    placeholder="{{ __('Wallet Address') }}"
                    name="bank_info[crypto_wallet]"
                    value="{{ Arr::get($model->bank_info, 'crypto_wallet') }}">
            </div>
            {!! Form::error('bank_info[crypto_wallet]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_cryto_currency">{{ __('Crypto Currency') }}:</label>
                <select id="bank_info_crypto_currency"
                    class="form-control"
                    placeholder="{{ __('Select Crypto Currency') }}"
                    name="bank_info[crypto_currency]"
                    value="{{ Arr::get($model->bank_info, 'crypto_currency') }}">
                    <option value="BTC" {{ Arr::get($model->bank_info, 'crypto_currency') == 'BTC' ? 'selected' : '' }}>BTC</option>
                    <option value="ETH" {{ Arr::get($model->bank_info, 'crypto_currency') == 'ETH' ? 'selected' : '' }}>ETH</option>
                    <option value="USDT" {{ Arr::get($model->bank_info, 'crypto_currency') == 'USDT' ? 'selected' : '' }}>USDT</option>
                </select>
            </div>
            {!! Form::error('bank_info[crypto_currency]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_upi_id">{{ __('UPI ID') }}:</label>
                <input id="bank_info_upi_id"
                    type="text"
                    class="form-control"
                    placeholder="{{ __('UPI ID') }}"
                    name="bank_info[upi_id]"
                    value="{{ Arr::get($model->bank_info, 'upi_id') }}">
            </div>
            {!! Form::error('bank_info[upi_id]', $errors) !!}

            <div class="form-group">
                <label for="bank_info_description">{{ __('Description') }}:</label>
                <textarea id="bank_info_description"
                    type="text"
                    class="form-control"
                    placeholder="{{ __('Description') }}"
                    name="bank_info[description]"
                    rows="4">{{ Arr::get($model->bank_info, 'description') }}</textarea>
            </div>
            {!! Form::error('bank_info[description]', $errors) !!}
        </div>
    </div>
</div>
