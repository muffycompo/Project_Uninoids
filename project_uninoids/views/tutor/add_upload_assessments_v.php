<div id="container">
	<h1>New Assessment</h1>

	<div id="body">
	
		<p><?php echo form_open_multipart('tutor/add_assessments_upload'); ?></p>
		
		<p>
			<label>Assessment Title <span style="color: red;">*</span></label><br />
			<?php echo form_input('a_name'); ?>
		</p>
		
		<p>
			<label>Description <span style="color: red;">*</span></label><br />
			<?php echo form_input('a_description'); ?>
		</p>
		
		<p>
			<label>Assessment File (Only .pdf and .doc allowed)<span style="color: red;">*</span></label><br />
			<?php echo form_upload('a_upload'); ?>
		</p>
		
		<p>
			<label>Upload File Type<span style="color: red;">*</span></label><br />
			<?php echo form_dropdown('a_ext', array('doc' => 'Microsoft Word (97 - 2003)','docx' => 'Microsoft Word (2007 - 2010)','pdf' => 'PDF')); ?>
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
		
		<p><?php echo form_submit('submit_assessment','Upload Assessment'); ?></p>
		
		<p><?php echo form_close(); ?></p>
		
		<p><?php echo anchor('tutor/manage_assessments','<< Cancel') ?></p>
	</div>
</div>