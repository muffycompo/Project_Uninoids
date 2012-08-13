<div id="container">
	<h1>Edit Study Material</h1>

	<div id="body">
	
		<p><?php echo form_open('admin/add_sm'); ?></p>
		
		<?php if($study_materials !== NULL) : ?>
			<?php foreach($study_materials as $study) : ?>
    		<p>
    			<label>Title <span style="color: red;">*</span></label><br />
    			<?php echo form_input('sm_title', set_value('sm_title',$study->sm_title)); ?>
    			<?php echo form_hidden('sm_id',$study->sm_id);?>
    		</p>
    		
    		<p>
    			<label>Website URL <span style="color: red;">*</span></label><br />
    			<?php echo form_input('sm_url', set_value('sm_url',$study->sm_url)); ?>
    		</p>
    		
    		<p>
    			<label>Curriculum</label><br />
    			<?php echo curriculum_dropdown('curriculum_id', '', set_value('curriculum_id',$study->curriculum_id)); ?>
    		</p>
    		
    		<p><?php echo form_submit('submit_sm','Update Study Material'); ?></p>
    		
    		<p><?php echo form_close(); ?></p>
    		<?php endforeach; ?>
		<?php endif; ?>
		
		<p><?php echo anchor('admin/manage_sm','<< Cancel') ?></p>
	</div>
</div>