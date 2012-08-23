<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Tutor Details</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Tutor Name</th>
                                            <th>Curriculum</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($tutor_details !== NULL) : ?>
                                    <?php foreach($tutor_details as $tutor) : ?>
                                    <tr>
                                        <td><?php echo expand_tutor_name_from_email($tutor->tutor_email); ?></td>
                                        <td><?php echo _expand_curriculum_name($tutor->curriculum_id); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="2">No Tutor details available to display!</td>

                                        </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                            <br/>
                            &nbsp;<?php echo anchor('admin/manage_tutors','Cancel','class="button"'); ?>
                      </div>
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>