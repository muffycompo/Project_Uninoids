
<!-- main content -->
<div class="content container">

    <!-- Add Dashboard Menu -->
     <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
    		<!-- blog posts -->
		<div class="twelve columns">
			
                    <h1>Study Materials</h1>
			
                    <!-- add comment form -->
                    <div class="cblock empty add_comment_form">
                        <div class="uninoids_tbl">
                            <table>
                                <thead>
                                        <tr>
                                            <th>Material Links</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if($materials !== NULL) : ?>
                                    <?php foreach($materials as $material) : ?>
                                    <tr>
                                        <td><?php echo anchor($material->sm_url,$material->sm_title,'target="_blank"'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                        <tr>
                                            <td>No Study Materials available to display!</td>
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