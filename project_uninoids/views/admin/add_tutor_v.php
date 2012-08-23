<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Create Tutors</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <?php echo form_open('admin/add_tutors'); ?>
                                <thead>
                                    <tr>
                                        <th>Curriculum(s)</th>
                                        <th>Tutor Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php if($curriculums !== NULL) : ?>
						<?php foreach($curriculums as $curriculum) : ?>
                                                    <p><?php echo form_checkbox('curriculum[]', set_value('curriculum', $curriculum->curriculum_id) ); ?> &nbsp;<?php echo $curriculum->curriculum_name; ?></p>
						<?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo form_input('tutor_email',  set_value('tutor_email'),'id="tutor_email" class="contact_input"  required'); ?>
                                            <input type="submit" name="submit_tutor" class="button" value="Create Tutor"/>&nbsp; <?php echo anchor('admin/manage_tutors','Cancel','class="button"'); ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php echo form_close(); ?>
                            </table>
                      </div>
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>