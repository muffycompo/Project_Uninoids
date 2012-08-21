 	<!-- main content -->
	<div class="content container">
		
            <!-- Add Dashboard Menu -->
            <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
		<!-- blog posts -->
		<div class="twelve columns blog_type_1">
                        
                        <div class="cblock empty blog_post">
                            <div class="post_content_dash">
                                <?php if(check_student_regno($this->session->userdata('user_id')) == NULL && $this->session->userdata('role_id') == 1) : ?>
                                    <div class="alert error"><strong>Notice!</strong> Your <strong>Matriculation Number</strong> has not been entered! Update your profile.</div>
                                <?php endif; ?>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. </p>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. </p>
                            </div>
                        </div>
				
		</div>
		
		
	<!-- end: main content -->
	</div>