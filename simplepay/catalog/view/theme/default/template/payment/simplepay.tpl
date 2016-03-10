<div class="buttons">
    <div class="right">
        <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm"
               class="button"/>
    </div>
</div>
<script src="https://checkout.simplepay.ng/simplepay.js"></script>
<script type="text/javascript">
    function formatAmount(amount) {
        var strAmount = amount.toString().split('.');
        var decimalPlaces = (strAmount[1] === undefined) ? 0 : strAmount[1].length;
        var formattedAmount = strAmount[0];

        if (decimalPlaces === 0) {
            formattedAmount += '00';

        } else if (decimalPlaces === 1) {
            formattedAmount += strAmount[1] + '0';

        } else if (decimalPlaces === 2) {
            formattedAmount += strAmount[1];
        }

        return formattedAmount;
    }

    $('#button-confirm').bind('click', function () {
        $('#button-confirm').attr('disabled', true);

        function processPayment(token) {
            $.ajax({
                url: 'index.php?route=payment/simplepay/send',
                type: 'post',
                data: {
                    token: token
                },
                dataType: 'json',
                success: function (response) {
                    if (response['error']) {
                        alert(response['error']);
                    }

                    if (response['success']) {
                        location = response['success'];
                    }
                    $('#button-confirm').attr('disabled', false);
                }
            });
        }

        var handler = SimplePay.configure({
            platform: 'opencart',
            token: processPayment,
            key: '<?php echo $key; ?>',
            image: '<?php echo $image; ?>'
        });

        handler.open(SimplePay.CHECKOUT,
                {
                    email: '<?php echo $email; ?>',
                    phone: '<?php echo $phone; ?>',
                    description: '<?php echo $description; ?> #<?php echo $order_id; ?>',
                    address: '<?php echo $address; ?>',
                    postal_code: '<?php echo $postal_code; ?>',
                    city: '<?php echo $city; ?>',
                    country: '<?php echo $country; ?>',
                    amount: formatAmount('<?php echo $amount; ?>'),
                    currency: '<?php echo $currency; ?>'
                });
    });
</script>