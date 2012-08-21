<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Study Materials</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Curriculum</th>
                                            <th><?php echo anchor('admin/add_sm','Add Study Material','class="small_btn"'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($study_materials !== NULL) : ?>
                                    <?php foreach($study_materials as $study) : ?>
                                    <tr>
                                        <td><?php echo anchor($study->sm_url,$study->sm_title,'target="_blank"'); ?></td>
                                        <td><?php echo _expand_curriculum_name($study->curriculum_id); ?></td>
                                        <td><?php echo anchor('admin/sm_action/edit/' . $study->sm_id,'Edit','class="small_btn"'); ?><?php echo anchor('admin/sm_action/delete/' . $study->sm_id,'Delete','class="small_btn"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="3">No Study Material(s) available to display!</td>

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