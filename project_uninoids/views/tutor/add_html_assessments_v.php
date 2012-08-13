<div id="container">
	<h1>New Assessment</h1>

	<div id="body">
	
		<p><?php echo form_open('tutor/add_assessments_html'); ?></p>
		
		<p>
			<label>Assessment Title <span style="color: red;">*</span></label><br />
			<?php echo form_input('a_name'); ?>
		</p>
		
		<p>
			<label>Description <span style="color: red;">*</span></label><br />
			<?php echo form_input('a_description'); ?>
		</p>
		
		<p>
			<label>Assessment Content <span style="color: red;">*</span></label><br />
			<?php echo form_textarea('a_content'); ?>
		</p>
		
		<p>
			<label>Learning Group</label><br />
			<?php echo lg_dropdown('lg_id', $this->session->userdata('email_address')); ?>
		</p>
		
		<p>
			<label>Start Date (dd/mm/yyyy)</label><br />
			<?php echo dropdown_datepicker('start_day','start_month','start_year'); ?>
		</p>
		
		<p>
			<label>Due Date (dd/mm/yyyy)</label><br />
			<?php echo dropdown_datepicker('due_day','due_month','due_year'); ?>
		</p>
		
		<p><?php echo form_submit('submit_assessment','Create Assessment'); ?></p>
		
		<p><?php echo form_close(); ?></p>
		
		<p><?php echo anchor('tutor/manage_assessments','<< Cancel') ?></p>
	</div>
</div>