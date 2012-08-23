<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
						
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        
                        <?php echo form_open('admin/add_curriculum',' class="clearfix ajax_contact_form"'); ?>
                        	
                            <div class="twelve columns">
                                <h1>New Curriculum</h1>
                            </div>

                            <div class="twelve columns">
                                <label>Curriculum Name: <span class="required_star">*</span></label>
                                <div><?php echo form_input('curriculum_name',  set_value('curriculum_name'),'id="curriculum_name" class="contact_input"  required'); ?></div>	
                                
                                <label>Status: <span class="required_star">*</span></label>
                                <div><?php echo form_dropdown('curriculum_status', array('1' => 'Inactive','2' => 'Active'), 2,'id="curriculum_status" class="contact_select" required'); ?></div>	

                                <input type="submit" name="submit_curriculum" class="button" value="Create Curriculum"/>&nbsp; <?php echo anchor('admin/manage_curriculum','Cancel','class="button"'); ?>
                            </div>
								
			<?php echo form_close(); ?>
                        
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>