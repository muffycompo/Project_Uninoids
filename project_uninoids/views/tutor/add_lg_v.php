<div id="container">
	<h1>New Learning Group</h1>

	<div id="body">
	
		<p><?php echo form_open('tutor/add_lg'); ?></p>
		
		<p>
			<label>Learning Group Name <span style="color: red;">*</span></label><br />
			<?php echo form_input('lg_name'); ?>
		</p>
		
		<!--<p>
			<label>Curriculum</label><br />
			<?php //echo curriculum_dropdown('curriculum_status'); ?>
		</p>-->
		
		<p>
			<label>Student Email List (comma separated) <span style="color: red;">*</span></label><br />
			<?php echo form_textarea('lg_student_list'); ?>
		</p>
		
		<p><?php echo form_submit('submit_lg','Create Learning Group'); ?></p>
		
		<p><?php echo form_close(); ?></p>
		
		<p><?php echo anchor('tutor/manage_lg','<< Cancel') ?></p>
	</div>
</div>