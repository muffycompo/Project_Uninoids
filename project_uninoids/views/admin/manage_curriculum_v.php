<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Manage Curriculum</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Curriculum Name</th>
                                            <th>Status</th>
                                            <th><?php echo anchor('admin/add_curriculum','Add New Curriculum','class="small_btn"'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($curriculums !== NULL) : ?>
                                    <?php foreach($curriculums as $curriculum) : ?>
                                    <tr>
                                        <td><?php echo $curriculum->curriculum_name; ?></td>
                                        <td><?php echo expand_curriculum_status($curriculum->status); ?></td>
                                        <td><?php echo anchor('admin/curriculum_action/edit/' . $curriculum->curriculum_id,'Edit','class="small_btn"'); ?><?php echo anchor('admin/curriculum_action/delete/' . $curriculum->curriculum_id,'Delete','class="small_btn"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td colspan="3">No curriculums available to display!</td>

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