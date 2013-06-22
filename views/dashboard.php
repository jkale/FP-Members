<div class="wrap nosubsub">
	<?php screen_icon(); ?>
	<?php
		echo "<div id=\"icon-index\" class=\"icon32\"><br></div><h2>" . __( 'FP Members', 'fp-members' ) . " ". __( 'Dashboard', 'fp-members' ) . "</h2>";
	?>
	<div id="dashboard-widgets-wrap">
		<div class="metabox-holder" id="dashboard-widgets">
			<div style="width: 49%;" class="postbox-container">
				<div class="meta-box-sortables ui-sortable" id="normal-sortables">

					<div class="postbox " id="dashboard_right_now">
						<h3 class="hndle"><span><?php _e('Members Log','fp-members'); ?></span></h3>
						<div class="inside">
							<?php $this->fp_members_output_members_log(); ?>
							<br class="clear">
						</div>
					</div>

					<?php
					do_action( 'membership_dashboard_left' );
					?>
				</div>
			</div>
			
			<br class="clear">
			
			<div style="width: 49%;" class="postbox-container">
				<div class="meta-box-sortables ui-sortable" id="normal-sortables">

					<div class="postbox " id="dashboard_right_now">
						<h3 class="hndle"><span><?php _e('Member Levels','fp-members'); ?></span></h3>
						<div class="inside">
							<table style="width: 50%;">
								<tr>
									<th style="text-align: left;">Level</th>
									<th style="text-align: right;">Members Registered</th>
								</tr>
								<tr>
										<?php 
											$members = $this->fp_members_output_members_count(); 
											foreach ($members as $role => $count) {
												echo "<td style='width: 25%;'>".$role."</td>";
												echo "<td style='text-align: right;'>".$count."</td>";
											}
										?>
								</tr>
							</table>
							<br class="clear">
						</div>
					</div>

					<?php
					do_action( 'membership_dashboard_left' );
					?>
				</div>
			</div>
		</div>
	</div>
	
</div>