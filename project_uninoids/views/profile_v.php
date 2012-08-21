 	<!-- main content -->
	<div class="content container">
            <!-- Add Dashboard Menu -->
            <?php $this->load->view('partials/sidebar', array('name' => name_from_email($this->session->userdata('email_address')),'nav' => $nav)); ?>
		<!-- blog posts -->
		<div class="twelve columns blog_type_1">
                        
                        <div class="cblock empty blog_post">
                            <div class="post_content_dash">
                             <h1><?php echo name_from_email($this->session->userdata('email_address')); ?>'s Profile</h1>
                             <div class="three columns">
                                <?php if($user_details['user_image_path'] != null) : ?>
                                   <img src="<?php echo $user_details['user_image_path']; ?>?imgmax=115" alt="<?php echo name_from_email($this->session->userdata('email_address')); ?>" title="<?php echo name_from_email($this->session->userdata('email_address')); ?>" />
                                   <?php echo anchor('https://plus.google.com/' . $user_details['user_id'],'I am on Google+','class="small" target="_blank"'); ?>
                                <?php else : ?>
                                   <img src="<?php echo base_url(); ?>assets/public_html/images/blank_avatar.png" alt="<?php echo name_from_email($this->session->userdata('email_address')); ?>" title="<?php echo name_from_email($this->session->userdata('email_address')); ?>" />
                                <?php endif; ?>
                                
                             </div>
                             <div class="eight columns">
                                <p>First Name: <strong><?php echo $user_details['first_name']; ?></strong></p>
                                <p>Last Name: <strong><?php echo $user_details['last_name']; ?></strong></p>
                                <p>Email Address: <strong><?php echo $user_details['email_address']; ?></strong></p>
                                <?php if($user_details['gender'] != NULL) : ?>
                                    <p>Gender: <strong><?php echo ucfirst($user_details['gender']); ?></strong></p>
                                <?php endif; ?>
                                <p>Role: <strong><?php echo expand_role_name($this->session->userdata('role_id')); ?></strong></p>
                             </div>
                            </div>
                        </div>
			
                        <div class="cblock empty add_comment_form">
                            <div class="twelve columns">
                                <?php if($this->session->flashdata('error')) : ?>
                                    <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
                                <?php elseif($this->session->flashdata('success')) : ?>
                                    <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
                                <?php endif; ?>
                            </div>

                                <?php echo form_open('dashboard/update_profile'); ?>
                                    <?php if($this->session->userdata('role_id') == 1) : ?>
                                    <div class="fields_left">
                                        <?php if($user_details['regno'] != NULL) : ?>
                                            <?php echo form_input('matric_no', set_value('matric_no',$user_details['regno']),'id="matric_no" tabindex="1" placeholder="Matriculation Number (Required)" required'); ?>
                                         <?php else : ?>
                                            <?php echo form_input('matric_no', set_value('matric_no'),'id="matric_no" tabindex="1" placeholder="Matriculation Number (Required)" required'); ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="fields_right">
                                        <?php if($user_details['twitter_username'] != NULL) : ?>
                                            <?php echo form_input('twitter_username', set_value('twitter_username',$user_details['twitter_username']),'id="email" tabindex="2" placeholder="Twitter Username"'); ?>
                                        <?php else : ?>
                                            <?php echo form_input('twitter_username', '','id="email" tabindex="2" placeholder="Twitter Username"'); ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php else : ?>
                                        <div class="fields_left">
                                            <?php if($user_details['twitter_username'] != NULL) : ?>
                                                <?php echo form_input('twitter_username', set_value('twitter_username',$user_details['twitter_username']),'id="email" tabindex="2" placeholder="Twitter Username"'); ?>
                                            <?php else : ?>
                                                <?php echo form_input('twitter_username', '','id="email" tabindex="2" placeholder="Twitter Username"'); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="clear"></div>
                                    <button type="submit" class="btn"><span>Update Profile</span></button>
                                
                                 <?php echo form_close(); ?>

                        <!-- end: add comment form -->
                        </div>

		</div>
		
		
	<!-- end: main content -->
	</div>