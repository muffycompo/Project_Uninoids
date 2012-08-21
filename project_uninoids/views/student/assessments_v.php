
<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Assessments</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Tutor</th>
                                            <th>Learning Group</th>
                                            <!--<th>Start Date</th>-->
                                            <th>Due Date</th>
                                            <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($assessments !== NULL) : ?>
                                    <?php foreach($assessments as $assessment) : ?>
                                    <tr>
                                        <td><?php echo $assessment->a_name; ?></td>
                                        <td><?php echo expand_tutor_name_from_email(tutor_email_from_id(expand_tutor_id_from_lg(expand_lg_id_from_assessment($assessment->a_id)))); ?></td>
                                        <td><?php echo expand_lg_name(expand_lg_id_from_assessment($assessment->a_id)); ?></td>
                                        <!--<td><?php //echo uninoids_date($assessment->a_start_date); ?></td>-->
                                        <td><?php echo uninoids_date($assessment->a_due_date); ?></td>
                                        <td><?php echo anchor($assessment->a_file_url,'View','class="small_btn" target="_blank"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="6">No Active Assessment(s) to display!</td>

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