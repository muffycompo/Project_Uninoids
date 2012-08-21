<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Assessments</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Assessment Title</th>
                                            <th>Learning Group</th>
                                            <th><?php echo anchor('tutor/add_assessments_html','New','class="small_btn"'); ?><?php echo anchor('tutor/add_assessments_upload','Upload','class="small_btn"'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($assessments !== NULL) : ?>
                                    <?php foreach($assessments as $assessment) : ?>
                                    <tr>
                                        <td><?php echo $assessment->a_name; ?></td>
                                        <td><?php echo expand_lg_name($assessment->lg_id); ?></td>
                                        <td><?php echo anchor($assessment->a_file_url,'View','target="_blank" class="small_btn"'); ?><?php echo anchor('tutor/assessment_action/delete/' . $assessment->a_id,'Delete','class="small_btn"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="3">No Assessments available to display!</td>

                                        </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                      </div>
                        
                      <div class="alert info"><strong>Info:</strong> You can only create one assessment per <strong>Learning Group</strong></div>

                    <!-- end: add comment form -->
                    </div>
                    
                    
		<!-- end: blog posts -->
		</div>
    
    
    <!-- end: main content -->
</div>