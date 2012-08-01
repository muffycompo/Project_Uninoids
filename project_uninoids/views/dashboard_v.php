<div id="container">
	<h1>Welcome, <?php echo $user_details['name']; ?></h1>

	<div id="body">
		<?php //var_dump($user_details, true); ?>
		<p><?php echo anchor('dashboard/profile','Profile') ?></p>
		<p><?php echo anchor('','Study Materials') ?></p>
		<p><?php echo anchor('','Assessment (Skill Based)') ?></p>
		<p><?php echo anchor('','Grades') ?></p>
		<p><?php echo anchor('','Certificates') ?></p>
		<p><?php echo anchor('dashboard/logout','Logout') ?></p>
	</div>
</div>