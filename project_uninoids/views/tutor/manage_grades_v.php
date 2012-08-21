
<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Grades</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Assessment</th>
                                            <th>Learning Group</th>
                                            <th></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($grades !== NULL) : ?>
                                    <?php foreach($grades as $grade) : ?>
                                    <tr>
                                        <td><?php echo expand_assessment_name($grade->a_id); ?></td>
                                        <td><?php echo expand_lg_name($grade->lg_id); ?></td>
                                        <td><?php echo anchor('tutor/grade_action/scores/'. $grade->lg_id,'Scores','class="small_btn"'); ?><?php echo anchor('tutor/grade_action/grades/'. $grade->a_id,'View Grades','class="small_btn"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="3">No Assessment has been graded yet!</td>

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