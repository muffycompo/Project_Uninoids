<div id="container">
	<h1>New Study Material</h1>

	<div id="body">
	
		<p><?php echo form_open('admin/add_sm'); ?></p>
		
		<p>
			<label>Title <span style="color: red;">*</span></label><br />
			<?php echo form_input('sm_title'); ?>
		</p>
		
		<p>
			<label>Website URL <span style="color: red;">*</span></label><br />
			<?php echo form_input('sm_url'); ?>
		</p>
		
		<p>
			<label>Curriculum</label><br />
			<?php echo curriculum_dropdown('curriculum_id'); ?>
		</p>
		
		<p><?php echo form_submit('submit_sm','Add Study Material'); ?></p>
		
		<p><?php echo form_close(); ?></p>
		
		<p><?php echo anchor('admin/manage_sm','<< Cancel') ?></p>
	</div>
</div>