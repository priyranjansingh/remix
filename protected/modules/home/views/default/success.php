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
						<a class="cd-select" href="javascript:void(0);">Membership Plan</a>
					</footer>  <!-- .cd-pricing-footer -->
				</li>
			</ul> <!-- .cd-pricing-wrapper -->
		</li>
		<li>
			<ul class="cd-pricing-wrapper">
				<li class="is-ended is-visible">
					<header class="cd-pricing-header">
						<h2>Payment Recieved</h2>
					</header> <!-- .cd-pricing-header -->					
					<div class="cd-pricing-body">
						<ul class="cd-pricing-features">

							<!-- <li class="payment_method"><em>2</em>Paypal</li> -->
						</ul>
					</div>
				</li>
			</ul>
		</li>
	</ul> <!-- .cd-pricing-list -->
		
	</div>
</div>