<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form method="post" action="" class="change-password-form">
	<div class="form-group">
		<label for="change-password-form-old-password"><?php echo __( 'Old password', 'wp-listings-directory' ); ?></label>
		<input id="change-password-form-old-password" class="form-control" type="password" name="old_password" required="required">
	</div><!-- /.form-control -->

	<div class="form-group">
		<label for="change-password-form-new-password"><?php echo __( 'New password', 'wp-listings-directory' ); ?></label>
		<input id="change-password-form-new-password" class="form-control" type="password" name="new_password" required="required" minlength="8">
	</div><!-- /.form-control -->

	<div class="form-group">
		<label for="change-password-form-retype-password"><?php echo __( 'Retype password', 'wp-listings-directory' ); ?></label>
		<input id="change-password-form-retype-password" class="form-control" type="password" name="retype_password" required="required" minlength="8">
	</div><!-- /.form-control -->

	<button type="submit" name="change_password_form" class="button"><?php echo __( 'Change Password', 'wp-listings-directory' ); ?></button>
</form>
