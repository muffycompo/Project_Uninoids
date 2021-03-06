<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Student(s) List for <?php echo '"' .strtoupper(expand_lg_name($lg_id)) . '"';?></h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                                <table class="un_tbl">
                                    <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Email Address</th>
                                                <th></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($student_lists !== NULL) : ?>
                                        <?php foreach($student_lists as $student) : ?>
                                           <?php echo student_grade_list($student->student_list, $lg_id); ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                            <tr>
                                                <td colspan="3">No Scores entered for this assessment!</td>
                                            </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                             <?php echo anchor('tutor/manage_grades','Cancel','class="button"'); ?>
                            
                      </div>
                    <!-- end: add comment form -->
                    </div>
                    
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>