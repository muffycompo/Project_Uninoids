<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Student Grades for <?php echo '"' . strtoupper(expand_lg_name(expand_lg_id_from_assessment(($a_id)))) . '"'; ?></h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Email Address</th>
                                            <th>Assessment</th>
                                            <th>Grade</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($student_grade !== NULL) : ?>
                                    <?php foreach($student_grade as $grade) : ?>
                                    <tr>
                                        <td><?php echo expand_tutor_name_from_email($grade->student_email); ?></td>
                                        <td><?php echo $grade->student_email; ?></td>
                                        <td><?php echo expand_assessment_name($grade->a_id); ?></td>
                                        <td><?php echo grade_from_score($grade->score, TRUE); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="4">No grades available for this assessment!</td>

                                        </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                            <br />
                            <?php if(result_status($a_id) == 2) { ?>
                                &nbsp;<?php echo anchor('tutor/result_visibity/1_' . $a_id,'Publish Result','class="button"')?>
                            <?php } else if(result_status($a_id) == 1) { ?>
                                &nbsp;<?php echo anchor('tutor/result_visibity/2_' . $a_id,'Unpublish Result','class="button"')?>
                             <?php } ?>
                            &nbsp;<?php echo anchor('tutor/manage_grades','Cancel','class="button"'); ?>
                      </div>
                    <!-- end: add comment form -->
                    </div>
                    
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>