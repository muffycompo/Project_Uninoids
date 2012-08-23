<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <!--<h1>New Learning Group</h1>-->
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <?php if($student_lists !== NULL) : ?>
			<?php foreach($student_lists as $student) : ?>
                            <?php echo form_open('tutor/add_grade',' class="clearfix ajax_contact_form"'); ?>

                                <div class="twelve columns">
                                    <h1>Edit Score for <?php echo '"' .name_from_email($student->student_email) . '"'; ?></h1>
                                </div>

                                <div class="twelve columns">
                                    <label>Score: <span class="required_star">*</span></label>
                                    <div><?php echo form_input('score',  set_value('score',$student->score),'id="lg_name" class="contact_input"  required'); ?></div>
                                    <?php echo form_hidden('a_id', $student->a_id); ?>
                                    <?php echo form_hidden('student_email', $student->student_email); ?>

                                    <input type="submit" name="submit_grade_edit" class="button" value="Update Score"/>&nbsp; <?php echo anchor('tutor/grade_action/scores/'.$lg_id,'Cancel','class="button"'); ?>
                                </div>

                            <?php echo form_close(); ?>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <table class="un_tbl">
                            <tbody>
                                <tr>
                                    <td>No score has been entered for this student!</td>
                                </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>