<div id="container">
	<h1>New Curriculum</h1>

	<div id="body">
	
		<p><?php echo form_open('admin/add_curriculum'); ?></p>
		
		<p>
			<label>Name of Curriculum <span style="color: red;">*</span></label><br />
			<?php echo form_input('curriculum_name'); ?>
		</p>
		
		<p>
			<label>Status</label><br />
			<?php echo form_dropdown('curriculum_status', array('1' => 'Inactive','2' => 'Active'), 1); ?>
		</p>
		
		<p><?php echo form_submit('submit_curriculum','Create Curriculum'); ?></p>
		
		<p><?php echo form_close(); ?></p>
		
		<p><?php echo anchor('admin/manage_curriculum','<< Cancel') ?></p>
	</div>
</div>