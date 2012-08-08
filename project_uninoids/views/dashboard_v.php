<div id="container">
	<?php if(! empty($user_details) && is_array($user_details)) : ?>
		<?php $name = $user_details['first_name'] . ' ' .$user_details['last_name']; ?>
		<h1>Welcome, <?php echo $name; ?></h1>
	<?php else : ?>
		<h1>Welcome to your Dashboard</h1>
	<?php endif; ?>
	<div id="body">
		<!--<p><?php echo anchor('dashboard/profile','Profile') ?></p>
		<p><?php echo anchor('dashboard/study_materials','Study Materials') ?></p>
		<p><?php echo anchor('dashboard/sba','Assessment (Skill Based)') ?></p>
		<p><?php echo anchor('','Grades') ?></p>
		<p><?php echo anchor('','Certificates') ?></p>
		<p><?php echo anchor('dashboard/groups_demo','Groups Demo (Experimental)') ?></p>
		<p><?php echo anchor('dashboard/logout','Logout') ?></p>-->
		<?php echo role_based_dashboard_menu($this->session->userdata('role_id')); ?>
	</div>
</div>