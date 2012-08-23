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
                            <p>Welcome to UNINOIDS, an online-based educational facility designed to enable you deliver training on Google products and services.</p>
                            <p>You can also use UNINOIDS for the teaching and learning of other Products and Services but with emphasis on Institutions running Google Apps for Education.</p>
                            </div>
                        </div>
				
		</div>
		
		
	<!-- end: main content -->
	</div>