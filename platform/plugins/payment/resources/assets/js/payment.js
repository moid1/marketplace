'use strict';

var BPayment = BPayment || {};
const NOWPAYMENTS = 'https://api.nowpayments.io/v1/';

var settings = {
    "url": "https://api.nowpayments.io/v1/",
    "method": "GET",
    "timeout": 0,
    "headers": {
        "x-api-key": "7R5W2YB-8YA4WHK-GPH5ANG-Y4PCHXX"
    },
};

let showLoaderOnPayment = () => {
    $('.payment-info-loading').show();
    $('.payment-checkout-btn').prop('disabled', true);
}

let hideLoaderOnPayment = () => {
    $('.payment-info-loading').hide();
    $('.payment-checkout-btn').prop('disabled', false);
}

BPayment.initResources = function () {
    let paymentMethod = $(document).find('input[name=payment_method]').first();

    if (paymentMethod.length) {
        paymentMethod.trigger('click').trigger('change');
        paymentMethod.closest('.list-group-item').find('.payment_collapse_wrap').addClass('show');
    }

    if ($('.stripe-card-wrapper').length > 0) {
        new Card({
            // a selector or DOM element for the form where users will
            // be entering their information
            form: '.payment-checkout-form', // *required*
            // a selector or DOM element for the container
            // where you want the card to appear
            container: '.stripe-card-wrapper', // *required*

            formSelectors: {
                numberInput: 'input#stripe-number', // optional — default input[name="number"]
                expiryInput: 'input#stripe-exp', // optional — default input[name="expiry"]
                cvcInput: 'input#stripe-cvc', // optional — default input[name="cvc"]
                nameInput: 'input#stripe-name' // optional - defaults input[name="name"]
            },

            width: 350, // optional — default 350px
            formatting: true, // optional - default true

            // Strings for translation - optional
            messages: {
                validDate: 'valid\ndate', // optional - default 'valid\nthru'
                monthYear: 'mm/yyyy', // optional - default 'month/year'
            },

            // Default placeholders for rendered fields - optional
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Full Name',
                expiry: '••/••',
                cvc: '•••'
            },

            masks: {
                cardNumber: '•' // optional - mask card number
            },

            // if true, will log helpful messages for setting up Card
            debug: false // optional - default false
        });
    }
}


function getCryptoCurrencies() {
    showLoaderOnPayment();
    settings.url = NOWPAYMENTS + 'merchant/coins';
    document.getElementById("crypto_currency").options.length = 0;
    $.ajax(settings).done(function (response) {
        var options = [];
        $(response.selectedCurrencies).each((index, currency) => {
            if (currency == "BTC" || currency == "ETH")
                options.push(new Option(currency.toUpperCase(), currency));
        });
        $('#crypto_currency').append(options);
        $('.cryptoCurrencySelector').removeClass('d-none');
        getEstimatedPrice("ETH");
    });

}

function getEstimatedPrice(currencyTo) {
    showLoaderOnPayment();
    settings.url = NOWPAYMENTS + 'estimate';
    settings.data = {
        "currency_to": currencyTo,
        "amount": $('input[name=amount]').val(),
        "currency_from": $('input[name=currency]').val(),
    },
        $.ajax(settings).done(function (response) {
            const txt = 'Crypto Total ';
            $('.estimated-amount .estimated-amount-description').text(txt + parseFloat(response.estimated_amount) + ' ' + (response.currency_to).toUpperCase());
            $('.crypto-payment-row').removeClass('d-none');
            $('#total-crypto-text').text(parseFloat(response.estimated_amount) + ' ' + (response.currency_to).toUpperCase());
            $('input[name=crypto_payment]').val(response.estimated_amount + ' ' + (response.currency_to).toUpperCase());
            hideLoaderOnPayment();

        });

}

BPayment.init = function () {
    BPayment.initResources();

    $(document).on('change', '.js_payment_method', function () {
        $('.payment_collapse_wrap').removeClass('collapse').removeClass('show').removeClass('active');
        if ($('input[name=payment_method]:checked').val() === 'crypto') {
            $('.payment-checkout-btn').text('Proceed To Crypto Checkout');
            getCryptoCurrencies();
        }else{
            $('.payment-checkout-btn').text('Checkout');

        }
    });

    $(document).off('click', '.payment-checkout-btn').on('click', '.payment-checkout-btn', function (event) {
        event.preventDefault();

        var _self = $(this);
        var form = _self.closest('form');
        _self.attr('disabled', 'disabled');
        var submitInitialText = _self.html();
        _self.html('<i class="fa fa-gear fa-spin"></i> ' + _self.data('processing-text'));

        if ($('input[name=payment_method]:checked').val() === 'stripe') {
            Stripe.setPublishableKey($('#payment-stripe-key').data('value'));
            Stripe.card.createToken(form, function (status, response) {
                if (response.error) {
                    if (typeof Botble != 'undefined') {
                        Botble.showError(response.error.message, _self.data('error-header'));
                    } else {
                        alert(response.error.message);
                    }
                    _self.removeAttr('disabled');
                    _self.html(submitInitialText);
                } else {
                    form.append($('<input type="hidden" name="stripeToken">').val(response.id));
                    form.submit();
                }
            });
        } else {
            form.submit();
        }
    });


};


$(document).ready(function () {
    BPayment.init();

    document.addEventListener('payment-form-reloaded', function () {
        BPayment.initResources();
    });

    $(document).on('change', '#crypto_currency', function () {
        var convertTo = $(this).find(":selected").text();
        getEstimatedPrice(convertTo);
    });
});
