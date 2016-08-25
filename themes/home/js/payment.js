$(function() {
    $(document).on("click", "#cc_pay", function(e){
        var $form = $('#payment-form');
        // Disable the submit button to prevent repeated clicks:
        $form.find('.submit').prop('disabled', true);
        // Request a token from Stripe:
        Stripe.card.createToken($form, stripeResponseHandler);
        // Prevent the form from being submitted:
        e.preventDefault();
        return false;
    });
});

function stripeResponseHandler(status, response) {
    // Grab the form:
    var $form = $('#payment-form');

    if (response.error) { // Problem!

        // Show the errors on the form:
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission

    } else { // Token was created!
        // Get the token ID:
        var token = response.id;
        alert(token);
        // Insert the token ID into the form so it gets submitted to the server:
        $form.append($('<input type="hidden" name="stripeToken">').val(token));
        alert('sucess');
        // Submit the form:
        $form.get(0).submit();
    }
}
;


$(document).ready(function() {
    $(document).on("click", ".payment_method_radio", function() {
        if ($(this).attr('data-type') == 'cc')
        {
            $("#paypal_method").hide();
            $("#cc_method").show();
        }
        else if ($(this).attr('data-type') == 'paypal')
        {
            $("#cc_method").hide();
            $("#paypal_method").show();
        }
    });
    
    $(document).on("click", "#paypal_submit", function() {
        $.ajax({
            url: base_url + "/home/SaveTransaction",
            method: "POST",
            success: function(data) {
                $("#paypal_hid_frm").submit();
            }
        })
    });

    $(document).on("click", "#mysubmit", function() {
        var code = $.trim($("#couponcode").val());
        $.ajax({
            url: base_url + "/home/ApplyCouponCode",
            method: "POST",
            dataType: "json",
            data:{'code':code},
            success: function(data) {
               if(data.status == 'failure')
               {
                   $("#coupon_err").html(data.message);
               }
               else if(data.status == 'success')
               {
                   $("input[name='a1']").val(data.amount);
                   $("#coupon_err").html(data.message);
               }    
            }
        })
    });
});