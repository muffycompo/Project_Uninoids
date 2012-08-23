<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <!--<h1>New Learning Group</h1>-->
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        
                        <?php echo form_open_multipart('tutor/add_assessments_upload',' class="clearfix ajax_contact_form"'); ?>
                        	
                            <div class="twelve columns">
                                <h1>New Assessment</h1>
                            </div>

                            <div class="twelve columns">
                                
                                <label>Assessment Title: <span class="required_star">*</span></label>
                                <div><?php echo form_input('a_name',  set_value('a_name'),'id="a_name" class="contact_input" required'); ?></div>	
                                
                                <label>Description:</label>
                                <div><?php echo form_textarea('a_description',  set_value('a_description'),'id="a_description" rows="5" cols="45" class="contact_input"'); ?></div>
                                
                                <label>Learning Group: <span class="required_star">*</span></label>
                                <div><?php echo lg_dropdown('lg_id',  $this->session->userdata('email_address'), NULL,'id="lg_curriculum" class="contact_select" required'); ?></div>	
                                
                                <label>Assessment File: <span class="required_star">*</span> (pdf, doc &amp; docx)</label>
                                <?php echo form_upload('a_upload'); ?>
                                
                                <label>Upload File Type: <span class="required_star">*</span></label>
                                <?php echo form_dropdown('a_ext', array('doc' => 'Microsoft Word (97 - 2003)','docx' => 'Microsoft Word (2007 - 2010)','pdf' => 'PDF'),NULL,'class="contact_select" required'); ?>
                                
                                <label>Due Date: (dd/mm/yyyy) <span class="required_star">*</span></label>
                                <div class="clearfix"><?php echo dropdown_datepicker('due_day','due_month','due_year', 'class="uninoids_date_picker"'); ?></div>
                                <input type="submit" name="submit_assessment" class="button" value="Upload Assessment" />&nbsp; <?php echo anchor('tutor/manage_assessments','Cancel','class="button"'); ?>
                            </div>
								
			<?php echo form_close(); ?>
                        
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>