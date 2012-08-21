<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Grades</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Assessment</th>
                                            <th>Tutor</th>
                                            <th>Score</th>
                                            <th>Grade</th>
                                            <th>Certificate</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($grades !== NULL) : ?>
                                    <?php foreach($grades as $grade) : ?>
                                    <tr>
                                        <td><?php echo expand_assessment_name($grade->a_id); ?></td>
                                        <td><?php echo expand_tutor_name_from_email(tutor_email_from_id(expand_tutor_id_from_lg(expand_lg_id_from_assessment($grade->a_id)))); ?></td>
                                        <td><?php echo $grade->score; ?></td>
                                        <td><?php echo grade_from_score($grade->score,TRUE); ?></td>
                                        <td><?php echo certificate_status($grade->a_id,$this->session->userdata('email_address')); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="5">No Score or Grade to display!</td>

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