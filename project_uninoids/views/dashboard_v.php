<div id="container">
	<?php if(! empty($user_details) && is_array($user_details)) : ?>
		<h1>Welcome, <?php echo $user_details[0]['first_name'] . ' ' .$user_details[0]['last_name']; ?></h1>
	<?php else : ?>
		<h1>Welcome to your Dashboard</h1>
	<?php endif; ?>
	<div id="body">
		<?php //var_dump($user_details, true); ?>
		<p><?php echo anchor('dashboard/profile','Profile') ?></p>
		<p><?php echo anchor('dashboard/study','Study Materials') ?></p>
		<p><?php echo anchor('','Assessment (Skill Based)') ?></p>
		<p><?php echo anchor('','Grades') ?></p>
		<p><?php echo anchor('','Certificates') ?></p>
		<p><?php echo anchor('dashboard/groups_demo','Groups Demo (Experimental)') ?></p>
		<p><?php echo anchor('dashboard/logout','Logout') ?></p>
	</div>
</div>