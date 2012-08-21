<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Tutors</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Tutor Name</th>
                                            <th>Curriculum(s)</th>
                                            <th><?php echo anchor('admin/add_tutors','Add New Tutor','class="small_btn"'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($tutors !== NULL) : ?>
                                    <?php foreach($tutors as $tutor) : ?>
                                    <tr>
                                        <td><?php echo expand_tutor_name_from_email($tutor->tutor_email); ?></td>
                                        <td><?php echo expand_tutor_curriculum_list($tutor->tutor_email); ?></td>
                                        <td><?php echo anchor('admin/tutor_action/details/' .format_uri_email($tutor->tutor_email,'@'),'View details','class="small_btn"'); ?><?php echo anchor('admin/tutor_action/delete/' .$tutor->tutor_id . '_' . format_uri_email($tutor->tutor_email,'@'),'Delete','class="small_btn"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="3">No Tutors has been added yet!</td>

                                        </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                      </div>
                    <!-- end: add comment form -->
                    </div>
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>