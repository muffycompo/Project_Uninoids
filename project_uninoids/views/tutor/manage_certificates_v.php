<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Certificates</h1>
			
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
                                <?php if($certs !== NULL) : ?>
                                    <?php foreach($certs as $cert) : ?>
                                    <tr>
                                        <td><?php echo expand_assessment_name($cert->a_id); ?></td>
                                        <td><?php echo expand_lg_name(expand_lg_id_from_assessment($cert->a_id)); ?></td>
                                        <td>
                                            <?php if($cert->status == 1) { ?>
                                                <?php echo anchor('tutor/cert_action/show/' . $cert->a_id,'Issue Certificates','class="small_btn"'); ?>
                                            <?php } else if($cert->status == 2) {?>
                                                <?php echo anchor('tutor/cert_action/hide/' . $cert->a_id,'Retrieve Certificates','class="small_btn"'); ?>
                                            <?php } ?>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="3">No Certificates available to display!</td>

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