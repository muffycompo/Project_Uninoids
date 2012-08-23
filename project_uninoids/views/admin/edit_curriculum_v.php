<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
						
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <?php if($curriculums !== NULL) : ?>
			<?php foreach($curriculums as $curriculum) : ?>
                            <?php echo form_open('admin/edit_curriculum',' class="clearfix ajax_contact_form"'); ?>

                                <div class="twelve columns">
                                    <h1>Edit Curriculum</h1>
                                </div>

                                <div class="twelve columns">
                                    <label>Curriculum Name: <span class="required_star">*</span></label>
                                    <div><?php echo form_input('curriculum_name', set_value('curriculum_name',$curriculum->curriculum_name),'id="curriculum_name" class="contact_input"  required'); ?></div>	
                                    <?php echo form_hidden('curriculum_id', set_value('curriculum_id',$curriculum->curriculum_id)); ?>

                                    <label>Status: <span class="required_star">*</span></label>
                                    <div><?php echo form_dropdown('curriculum_status', array('1' => 'Inactive','2' => 'Active'), 2,'id="curriculum_status" class="contact_select" required'); ?></div>	

                                    <input type="submit" name="submit_curriculum" class="button" value="Update Curriculum"/>&nbsp; <?php echo anchor('admin/manage_curriculum','Cancel','class="button"'); ?>
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