<!--<div id="container">
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
</div>-->



<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
						
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <?php if($study_materials !== NULL) : ?>
			<?php foreach($study_materials as $study) : ?>
                            <?php echo form_open('admin/add_sm',' class="clearfix ajax_contact_form"'); ?>

                                <div class="twelve columns">
                                    <h1>Edit Study Material</h1>
                                </div>

                                <div class="twelve columns">
                                    <label>Title: <span class="required_star">*</span></label>
                                    <div><?php echo form_input('sm_title', set_value('sm_title',$study->sm_title),'id="sm_title" class="contact_input" required'); ?></div>	
                                    <?php echo form_hidden('sm_id',$study->sm_id);?>

                                    <label>Website URL: <span class="required_star">*</span></label>
                                    <div><?php echo form_input('sm_url', set_value('sm_url',$study->sm_url),'id="sm_url" class="contact_input" required'); ?></div>
                                    
                                    <label>Curriculum: <span class="required_star">*</span></label>
                                    <div><?php echo curriculum_dropdown('curriculum_id', '', set_value('curriculum_id',$study->curriculum_id),'class="contact_select" required'); ?></div>		

                                    <input type="submit" name="submit_sm" class="button" value="Update Study Material"/>&nbsp; <?php echo anchor('admin/manage_sm','Cancel','class="button"'); ?>
                                </div>

                            <?php echo form_close(); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    <!-- end: main content -->
</div>