<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="box-white-dashboard max-600">
	<form method="post" action="" class="change-password-form form-theme">
		<div class="clearfix">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label><?php echo esc_html__( 'Old password', 'foogra' ); ?></label>
						<input id="change-password-form-old-password" class="form-control" type="password" name="old_password" required="required">
					</div><!-- /.form-control -->
				</div>
				<div class="col-12">
					<div class="form-group">
						<label><?php echo esc_html__( 'New password', 'foogra' ); ?></label>
						<input id="change-password-form-new-password" class="form-control" type="password" name="new_password" required="required" minlength="8">
					</div><!-- /.form-control -->
				</div>
				<div class="col-12">
					<div class="form-group">
						<label><?php echo esc_html__( 'Retype password', 'foogra' ); ?></label>
						<input id="change-password-form-retype-password" class="form-control" type="password" name="retype_password" required="required" minlength="8">
					</div><!-- /.form-control -->
				</div>
			</div>
		</div>
		<button type="submit" name="change_password_form" class="button btn btn-theme btn-inverse"><?php echo esc_html__( 'Change Password', 'foogra' ); ?></button>
	</form>
</div>