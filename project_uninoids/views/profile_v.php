<div id="container">
	<?php $name = $user_profile_details['first_name'] . ' ' . $user_profile_details['last_name']; ?>
	<h1><?php echo $name; ?> Profile</h1>

	<div id="body">
		<?php if($user_profile_details['user_image_path'] != null) : ?>
			<p><img src="<?php echo $user_profile_details['user_image_path']; ?>?imgmax=115" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" ></p>
		<?php endif; ?>
		<p>First Name: <strong><?php echo $user_profile_details['first_name']; ?></strong></p>
		<p>Last Name: <strong><?php echo $user_profile_details['last_name']; ?></strong></p>
		<p>Email Address: <strong><?php echo $user_profile_details['email_address']; ?></strong></p>
		<?php if($user_profile_details['gender'] != NULL) : ?>
		    <p>Gender: <strong><?php echo ucfirst($user_profile_details['gender']); ?></strong></p>
		<?php endif; ?>
		<p><?php echo anchor('dashboard','<< Back to Dashboard'); ?></p>
	</div>
</div>