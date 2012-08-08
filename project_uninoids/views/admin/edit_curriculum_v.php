<div id="container">
	<h1>Edit Curriculum</h1>

	<div id="body">

		<p><?php echo form_open('admin/add_curriculum'); ?></p>
		
		<?php if($curriculums !== NULL) : ?>
			<?php foreach($curriculums as $curriculum) : ?>
			<p>
				<label>Name of Curriculum <span style="color: red;">*</span></label><br />
				<?php echo form_input('curriculum_name', set_value('curriculum_name',$curriculum->curriculum_name)); ?>
				<?php echo form_hidden('curriculum_id', set_value('curriculum_id',$curriculum->curriculum_id)); ?>
			</p>

			<p>
				<label>Status</label><br />
				<?php echo form_dropdown('curriculum_status', array('0' => 'Inactive','1' => 'Active'), set_value('curriculum_status',$curriculum->status)); ?>
			</p>
			
			<p><?php echo form_submit('submit_curriculum','Update'); ?></p>
			
			<p><?php echo form_close(); ?></p>
		<?php endforeach; ?>
		<?php endif; ?>
		<p><?php echo anchor('admin/manage_curriculum','<< Cancel') ?></p>
	</div>
</div>