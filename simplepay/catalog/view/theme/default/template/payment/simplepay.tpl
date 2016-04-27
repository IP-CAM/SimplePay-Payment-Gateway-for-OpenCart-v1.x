<div class="buttons">
    <div class="right">
        <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm"
               class="button"/>
    </div>
</div>
<script type="text/javascript">
    function processPayment(token) {
        jQuery.ajax({
            url: 'index.php?route=payment/simplepay/send',
            type: 'post',
            data: {
                token: token,
                amount: SimplePay.amountToLower('<?php echo $amount; ?>'),
                currency: '<?php echo $currency; ?>'
            },
            dataType: 'json',
            success: function (response) {
                if (response['error']) {
                    alert(response['error']);
                }

                if (response['success']) {
                    location = response['success'];
                }
                jQuery('#button-confirm').attr('disabled', false);
            }
        });
    }

    var simplepayLoader;
    var loaded = false;
    var handler;
    jQuery.getScript('https://checkout.simplepay.ng/simplepay.js').done(function () {
        handler = SimplePay.configure({
            platform: 'opencart-2',
            token: processPayment,
            key: '<?php echo $key; ?>',
            image: '<?php echo $image; ?>'
        });
        loaded = true;
    });

    function openHandler() {
        handler.open(SimplePay.CHECKOUT, {
            email: '<?php echo $email; ?>',
            phone: '<?php echo $phone; ?>',
            description: '<?php echo $description; ?> #<?php echo $order_id; ?>',
            address: '<?php echo $address; ?>',
            postal_code: '<?php echo $postal_code; ?>',
            city: '<?php echo $city; ?>',
            country: '<?php echo $country; ?>',
            amount: SimplePay.amountToLower('<?php echo $amount; ?>'),
            currency: '<?php echo $currency; ?>'
        });
        jQuery('#button-confirm').attr('disabled', false);
    }

    jQuery('body').on('click', '#button-confirm', function () {
        jQuery('#button-confirm').attr('disabled', true);

        simplepayLoader = setInterval(function () {
            if (loaded) {
                openHandler();
                clearInterval(simplepayLoader);
            }
        }, 300);
    });
</script>