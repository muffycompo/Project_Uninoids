<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Learning Groups</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Learning Group Name</th>
                                            <th>Tutor</th>
                                            <th>Curriculum</th>
                                            <th><?php echo anchor('tutor/add_lg','New Learning Group','class="small_btn"') ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($learning_groups !== NULL) : ?>
                                    <?php foreach($learning_groups as $lg) : ?>
                                    <tr>
                                        <td><?php echo $lg->lg_name; ?></td>
                                        <td><?php echo expand_tutor_name_from_email($this->session->userdata('email_address')); ?></td>
                                        <td><?php echo _expand_curriculum_name(expand_curriculum_from_id($lg->tutor_id)); ?></td>
                                        <td><?php echo anchor('tutor/lg_action/sl/' . $lg->lg_id,'View Students','class="small_btn"'); ?><?php echo anchor('tutor/lg_action/delete/' . $lg->lg_id,'Delete','class="small_btn"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="4">No Learning Groups available to display!</td>

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