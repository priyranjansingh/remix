<div class="cd-pricing-container cd-has-margins inner_con bg_grey">
    <div class="wraper fc_black">
        <h2 class="fw600 mart15 marb15">Buy Your Membership Plan</h2>
        <ul class="cd-pricing-list cd-bounce-invert">
            <li>
                <ul class="cd-pricing-wrapper">
                    <li class="is-ended is-visible">
                        <header class="cd-pricing-header">
                            <h2><?php echo $plan->plan_name; ?></h2>

                            <div class="cd-price">
                                <span class="cd-currency">$</span>
                                <span class="cd-value"><?php echo $plan->plan_price; ?></span>
                                <span class="cd-duration"><?php echo $plan->plan_duration; ?></span>
                            </div>
                        </header> <!-- .cd-pricing-header -->

                        <div class="cd-pricing-body">
                            <ul class="cd-pricing-features">
                                <li><em>1</em> <?php echo $plan->plan_desc; ?></li>
                            </ul>
                        </div> <!-- .cd-pricing-body -->

                        <footer class="cd-pricing-footer">
                            <a class="cd-select" href="javascript:void(0);">Choosen</a>
                        </footer>  <!-- .cd-pricing-footer -->
                    </li>
                </ul> <!-- .cd-pricing-wrapper -->
            </li>
            <li>
                <ul class="cd-pricing-wrapper">
                    <li class="is-ended is-visible">
                        <header class="cd-pricing-header">
                            <h2>Payment Method</h2>
                        </header> <!-- .cd-pricing-header -->					
                        <div class="cd-pricing-body">
                            <ul class="cd-pricing-features">
                                <li class="payment_method">
                                    <form>
                                        <span><input type="radio" class="payment_class" id="credit_card" name="payment_type">Credit Card</span>
                                        <span><input type="radio" class="payment_class" id="paypal" name="payment_type">Paypal</span>
                                    </form>
                                </li>
                                <li id="credit_card_form" style="display:none">
                                    <form action="<?php echo base_url() . '/home/process'; ?>" method="POST" id="payment-form">
                                        <span class="payment-errors"></span>

                                        <div class="form-row">
                                            <label>
                                                <span>Card Number</span>
                                                <input type="text" class="control-label" size="20" maxlength="16" data-stripe="number">
                                            </label>
                                        </div>

                                        <div class="form-row">
                                            <label>
                                                <span>Expiration (MM/YY)</span>
                                                <input type="text" class="control-label" size="2" maxlength="2" data-stripe="exp_month">
                                            </label>
                                            <span> / </span>
                                            <input type="text" class="control-label" size="4" maxlength="4" data-stripe="exp_year">
                                        </div>

                                        <div class="form-row">
                                            <label>
                                                <span>CVC</span>
                                                <input type="text" class="control-label" size="4" maxlength="4" data-stripe="cvc">
                                            </label>
                                        </div>

                                        <input type="submit" class="submit" value="Pay Now">
                                    </form>
                                </li>

                                <li id="paypal_form" style="display:none">
                                    <form action="#" method="POST" >
                                        <input type="button" id="paypal_submit" class="submit" value="Pay Now">
                                    </form>
                                    <form id="paypal_hid_frm" name="frm_payment_method" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                                        <input type="hidden" name="business" value="singh.priyranjan-facilitator@gmail.com" />
                                        <input type="hidden" name="notify_url" value="<?php echo domainUrl() ?>/home/notify" />
                                        <input type="hidden" name="cancel_return" value="<?php echo domainUrl() ?>/home/cancel" />
                                        <input type="hidden" name="return" value="<?php echo domainUrl() ?>/home/thank" />
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
                                        <input type="text" name="a1" value="<?php echo $plan->plan_price; ?>" />
                                        <input type="hidden" name="p1" value="<?php echo $plan->plan_duration; ?>" />
                                        <input type="hidden" name="t1" value="<?php echo getPlanDurationLabelPaypal($plan->plan_duration_type); ?>" />
                                        <input type="hidden" name="a3" value="<?php echo $plan->plan_price; ?>" />
                                        <input type="hidden" name="p3" value="<?php echo $plan->plan_duration; ?>" />
                                        <input type="hidden" name="t3" value="<?php echo getPlanDurationLabelPaypal($plan->plan_duration_type); ?>" />
                                    </form>
                                </li>
                                <!-- <li class="payment_method"><em>2</em>Paypal</li> -->
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        </ul> <!-- .cd-pricing-list -->

    </div>
</div>
<script type="text/javascript">
    Stripe.setPublishableKey('pk_test_jwghFvJb4NmKWhA16j1wgQva');
</script>