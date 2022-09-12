<template>
    <div class="demo">
        <google-pay-button
            environment="TEST"
            :button-color="buttonColor"
            :button-type="buttonType"
            :button-size-mode="isCustomSize ? 'fill' : 'static'"
            :paymentRequest.prop="paymentRequest"
            @loadpaymentdata="onLoadPaymentData"
            @error="onError"
            :style="{ width: `${buttonWidth}px`, height: `${buttonHeight}px` }"
        ></google-pay-button>
    </div>

    <div class="note" :style="{ display: isTop ? 'none' : '' }">
        <p>
            Note: This page may need to open in a new window for it to function
            correctly.
        </p>
        <p><a href="/" target="_blank">Open in new window</a>.</p>
    </div>
</template>

<script>
import "@google-pay/button-element";

export default {
    data: () => ({
        buttonColor: "default",
        buttonType: "buy",
        isCustomSize: false,
        buttonWidth: 240,
        buttonHeight: 40,
        isTop: window === window.top,

        paymentRequest: {
            apiVersion: 2,
            apiVersionMinor: 0,
            allowedPaymentMethods: [
                {
                    type: "CARD",
                    parameters: {
                        allowedAuthMethods: ["PAN_ONLY", "CRYPTOGRAM_3DS"],
                        allowedCardNetworks: ["AMEX", "VISA", "MASTERCARD"],
                    },
                    tokenizationSpecification: {
                        type: "PAYMENT_GATEWAY",
                        parameters: {
                            gateway: "example",
                            gatewayMerchantId: "exampleGatewayMerchantId",
                        },
                    },
                },
            ],
            merchantInfo: {
                merchantId: "12345678901234567890",
                merchantName: "Demo Merchant",
            },
            transactionInfo: {
                totalPriceStatus: "FINAL",
                totalPriceLabel: "Total",
                totalPrice: "100.00",
                currencyCode: "USD",
                countryCode: "US",
            },
        },
    }),
    methods: {
        onLoadPaymentData: (event) => {
            console.log("load payment data", event.detail);
        },
        onError: (event) => {
            console.error("error", event.error);
        },
    },
};
</script>

<style>
body,
html,
label {
    font: 400 16px/24px Roboto, Noto Sans, Noto Sans JP, Noto Sans KR,
        Noto Naskh Arabic, Noto Sans Thai, Noto Sans Hebrew, Noto Sans Bengali,
        sans-serif;
}

form {
    display: inline-block;
}

form.top-bottom {
    margin: -4px -5px;
}

form.top-bottom label {
    margin-top: 10px;
}

form label {
    display: block;
}

form label.control {
    display: inline-block;
    width: 200px;
    margin: 4px 5px;
}

form label > span {
    display: inline-block;
    margin-right: 5px;
}

form label.control > span {
    display: block;
}

form label .value {
    font-size: 80%;
    color: #666;
}

form select {
    -moz-appearance: none;
    -webkit-appearance: none;
    border: 1px solid #dadce0;
    border-radius: 4px;
    box-shadow: none;
    color: #202124;
    cursor: pointer;
    display: inline-block;
    font: 500 14px/36px Google Sans, Noto Sans, Noto Sans JP, Noto Sans KR,
        Noto Naskh Arabic, Noto Sans Thai, Noto Sans Hebrew, Noto Sans Bengali,
        sans-serif;
    height: 36px;
    line-height: 34px;
    outline: 0;
    padding: 0 27px 0 15px;
    text-align: left;
    text-indent: 0.01px;
    text-overflow: ellipsis;
    transition: background-color 0.2s;
    vertical-align: middle;
    white-space: nowrap;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="4" viewBox="0 0 20 4"><path d="M0,0l4,4l4-4H0z" fill="%23212121"/></svg>')
        #fff no-repeat 100%;
}

form.top-bottom select {
    width: 100%;
}

form option {
    font-weight: normal;
    display: block;
    white-space: pre;
    min-height: 1.2em;
    padding: 0 2px 1px;
}

form input[type="range"] {
    width: 100%;
}

.demo {
    margin-top: 20px;
    margin-bottom: 30px;
    min-height: 40px;
}

.note {
    font: 400 16px/24px Roboto, Noto Sans, Noto Sans JP, Noto Sans KR,
        Noto Naskh Arabic, Noto Sans Thai, Noto Sans Hebrew, Noto Sans Bengali,
        sans-serif;
}
</style>
