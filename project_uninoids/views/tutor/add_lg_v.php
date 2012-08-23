<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <!--<h1>New Learning Group</h1>-->
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        
                        <?php echo form_open('tutor/add_lg',' class="clearfix ajax_contact_form"'); ?>
                        	
                            <div class="twelve columns">
                                <h1>New Learning Group</h1>
                            </div>

                            <div class="twelve columns">
                                <label>Learning Group Name: <span class="required_star">*</span></label>
                                <div><?php echo form_input('lg_name',  set_value('lg_name'),'id="lg_name" class="contact_input"  required'); ?></div>	
                                
                                <label>Curriculum: <span class="required_star">*</span></label>
                                <div><?php echo curriculum_dropdown('lg_curriculum',  $this->session->userdata('email_address'), NULL,'id="lg_curriculum" class="contact_select" required'); ?></div>	
                                
                                <label>Students Email List: (comma separated) <span class="required_star">*</span></label>
                                <div><?php echo form_textarea('lg_student_list',  set_value('lg_student_list'),'id="message" rows="5" cols="45" class="contact_input" required'); ?></div>	
                                <input type="submit" name="submit_lg" class="button" value="Create Learning Group"/>&nbsp; <?php echo anchor('tutor/manage_lg','Cancel','class="button"'); ?>
                            </div>
								
			<?php echo form_close(); ?>
                        
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>