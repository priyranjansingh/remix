<div class="body">
        
            <div class="sky-form">
                <fieldset>                  
                    <div class="row">
                        <section class="col col-12">
                            <label class="select">
                                Your Choosen Plan: <?php echo $plan->plan_name.' - $'.$plan->plan_price; ?>
                            </label>
                        </section>
                    </div>
                </fieldset>
                <fieldset>
                    <section>
                        <div class="inline-group">
                            <label class="radio">Apply Coupon</label>
                        </div>
                    </section> 
                </fieldset>    
                <form name="couponcode_frm" id="couponcode_frm" action="">
                    <fieldset>
                        <div class="row">
                            <section class="col col-6">
                                <label class="input">
                                    <i class="icon-prepend icon-user"></i>
                                    <input type="text" name="couponcode" id="couponcode" placeholder="Enter Coupon Code">
                                </label>
                                <div id="coupon_err"></div>
                            </section>
                            <section class="col col-6">
                                <label class="input">
                                    <input type="button" name="mysubmit" id="mysubmit" class="button" value="Apply Coupon">
                                </label>
                            </section>
                        </div>
                    </fieldset>    
                </form>                  
                
                <fieldset>
                    <section>
                        <div class="inline-group">
                            <label class="radio">
                                <input type="radio" name="radio-inline" data-type="cc" class="payment_method_radio">
                                <i></i>Credit Card
                            </label>
                            <label class="radio">
                                <input type="radio" name="radio-inline" data-type="paypal" class="payment_method_radio">
                                <i></i>PayPal
                            </label>
                        </div>
                    </section>                  
                    <div id="cc_method" style="display:none;">
                    <form action="<?php echo base_url() . '/home/process'; ?>" method="POST" id="payment-form">
                        <span class="payment-errors"></span>

                        <div class="row">
                            <section class="col col-10">
                                <label class="input">
                                    <input type="text" placeholder="Card numberd" size="20" maxlength="20" data-stripe="number">
                                </label>
                            </section>
                            <section class="col col-2">
                                <label class="input">
                                    <input type="text" maxlength="3" placeholder="CVV" size="4" maxlength="4" data-stripe="cvc">
                                </label>
                            </section>
                        </div>

                        <div class="row">
                            <label class="label col col-4">Expiration date</label>
                            <section class="col col-5">
                                <label class="select">
                                    <select data-stripe="exp_month">
                                        <option value="0" selected disabled>Month</option>
                                        <option value="1">January</option>
                                        <option value="1">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <i></i>
                                </label>
                            </section>
                            <section class="col col-3">
                                <label class="input">
                                    <input type="text" maxlength="4" placeholder="Year" data-stripe="exp_year">
                                </label>
                            </section>
                        </div>

                        <input type="submit" class="submit button" id="cc_pay" value="Pay Now">
                    </form>
                    </div>
                    <div id="paypal_method" style="display:none;">
                        <form action="#" method="POST" >
                            <input type="button" id="paypal_submit" class="submit button" value="Pay Now">
                        </form>
                        <form id="paypal_hid_frm" name="frm_payment_method" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="business" value="<?php echo getParam('paypal_business_email'); ?>" />
                            <input type="hidden" name="notify_url" value="<?php echo getParam('paypal_notify_url'); ?>" />
                            <input type="hidden" name="cancel_return" value="<?php echo getParam('paypal_cancel_url'); ?>" />
                            <input type="hidden" name="return" value="<?php echo getParam('paypal_return_url'); ?>" />
                            <input type="hidden" name="rm" value="2" />
                            <input type="hidden" name="lc" value="" />
                            <input type="hidden" name="no_shipping" value="1" />
                            <input type="hidden" name="no_note" value="1" />
                            <input type="hidden" name="currency_code" value="USD" />
                            <input type="hidden" name="page_style" value="paypal" />
                            <input type="hidden" name="charset" value="utf-8" />
                            <input type="hidden" name="item_name" value="<?php echo $plan->plan_name; ?>" />
                            <input type="hidden" name="custom" value="<?php echo $user->id."#".$plan->id; ?>" />
                            <input type="hidden" name="cmd" value="_xclick-subscriptions" />
                            <input type="hidden" name="src" value="1" />
                            <input type="hidden" name="srt" value="0" />
                            <input type="hidden" name="a1" value="<?php echo $plan->plan_price; ?>" />
                            <input type="hidden" name="p1" value="<?php echo $plan->plan_duration; ?>" />
                            <input type="hidden" name="t1" value="<?php echo getPlanDurationLabelPaypal($plan->plan_duration_type); ?>" />
                            <input type="hidden" name="a3" value="<?php echo $plan->plan_price; ?>" />
                            <input type="hidden" name="p3" value="<?php echo $plan->plan_duration; ?>" />
                            <input type="hidden" name="t3" value="<?php echo getPlanDurationLabelPaypal($plan->plan_duration_type); ?>" />
                        </form>        
                    </div>
                </fieldset>
            
        </div>
    </div>
<?php
        $baseUrl = Yii::app()->theme->baseUrl;
 ?>
<script type="text/javascript">
    Stripe.setPublishableKey('<?php echo getParam('stripe_access_key'); ?>');
</script>
