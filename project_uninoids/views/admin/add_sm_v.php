<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <!--<h1>New Learning Group</h1>-->
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        
                        <?php echo form_open('admin/add_sm',' class="clearfix ajax_contact_form"'); ?>
                        	
                            <div class="twelve columns">
                                <h1>New Study Material</h1>
                            </div>

                            <div class="twelve columns">
                                <label>Title: <span class="required_star">*</span></label>
                                <div><?php echo form_input('sm_title',  set_value('sm_title'),'id="sm_title" class="contact_input"  required'); ?></div>	
                                
                                <label>Website URL: <span class="required_star">*</span></label>
                                <div><?php echo form_input('sm_url',  set_value('sm_url'),'id="sm_url" class="contact_input"  required'); ?></div>	
                                
                                <label>Curriculum: <span class="required_star">*</span></label>
                                <div><?php echo curriculum_dropdown('curriculum_id',  '', NULL,'id="curriculum_id" class="contact_select" required'); ?></div>	
                                
                                <input type="submit" name="submit_sm" class="button" value="Add Study Material"/>&nbsp; <?php echo anchor('tutor/manage_sm','Cancel','class="button"'); ?>
                            </div>
								
			<?php echo form_close(); ?>
                        
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>
