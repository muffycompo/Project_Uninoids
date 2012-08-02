<div id="container">
	<h1>Project Uninoids</h1>

	<div id="body">
		<p><strong>Create a New File</strong></p>
		<pre>
			<?php //print_r($google_drive); ?>
		</pre>
		<p><?php echo form_open('dashboard/new_file'); ?></p>
		
		<p>
			<label>Name <span style="color: red;">*</span></label><br />
			<?php echo form_input('file_name'); ?>
		</p>
		
		<p>
			<label>Description</label><br />
			<?php echo form_input('file_description'); ?>
		</p>
		
		<p>
			<label>Body <span style="color: red;">*</span></label><br />
			<?php echo form_textarea('file_body'); ?>
		</p>
			
		<p>
			<label>Type</label><br />
			<?php echo form_dropdown('file_ext', array('doc' => 'Word'), 'doc'); ?>
		</p>
		
		
		<p><?php echo form_submit('submit','Create File'); ?></p>
		
		
		<p><?php echo form_close(); ?></p>
		
		<p><?php echo anchor('dashboard/study','<< Back') ?></p>
	</div>
</div>