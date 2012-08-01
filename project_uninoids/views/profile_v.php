<div id="container">
	<h1><a href="<?php echo $user_profile_details['link']; ?>" alt="<?php echo $user_profile_details['name']; ?>" title="<?php echo $user_profile_details['name']; ?>" target="_blank"><?php echo $user_profile_details['name']; ?></a> Profile</h1>

	<div id="body">
		<?php //var_dump($user_profile_details, true); ?>
		<?php 
			$dob = explode('-',$user_profile_details['birthday']);
			$d = $dob[2] . '/' . $dob[1]; 
		?>
		<p><img src="<?php echo $user_profile_details['picture']; ?>?sz=50" alt="<?php echo $user_profile_details['name']; ?>" title="<?php echo $user_profile_details['name']; ?>" ></p>
		<p>First Name: <strong><?php echo $user_profile_details['given_name']; ?></strong></p>
		<p>Last Name: <strong><?php echo $user_profile_details['family_name']; ?></strong></p>
		<p>Email Address: <strong><?php echo $user_profile_details['email']; ?></strong></p>
		<p>Gender: <strong><?php echo ucfirst($user_profile_details['gender']); ?></strong></p>
		<p>Date of Birth: <strong><?php echo $d; ?></strong></p>
		
		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
</div>