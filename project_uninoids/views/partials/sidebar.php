    <div class="sixteen columns">
        <?php //var_dump($name); ?>
        <div class="breadcrumb">
        <?php if(isset($name)) : ?>
            <div>Welcome <strong><?php echo $name; ?></strong></div><br>
        <?php else : ?>
            <div>Welcome to your Dashboard</div><br>
        <?php endif; ?>
           </div>
    </div>
		
		<!-- widgets sidebar (modules) -->
		<div class="four columns iphone_nopadding">
			
			<!-- blog categories -->
			<div class="module">
				<div class="module_inner">
					<h2 class="module_title"><?php echo anchor('dashboard','Dashboard'); ?> Menu</h2>
					<?php echo role_based_dashboard_menu($this->session->userdata('role_id'),$nav); ?>
				</div>
			<!-- end: blog categories -->
			</div>
			
                        
			<!-- tabbed content (popular posts) -->
			<div class="module">
				<div class="module_inner tabs">
				
					<div class="tabbed">
						<a href="#popular" class="active">Google+</a>
						<a href="#recent">Calender</a>
					</div>
					
					<div class="tab_padding">
						<div class="tab_content" id="popular">
						<!-- featured post -->
                                                    <?php if(!empty($gplus_feeds)) : ?>
                                                    <?php foreach ($gplus_feeds->items as $activity) : ?>
                                                        
                                                        <?php if(! empty($activity->object->content)) : ?>
                                                            <div class="featured_post">
                                                                <img src="<?php echo base_url(); ?>assets/public_html/images/post_thumbnail.png" alt="post_thumbnail" />

                                                                <div>
                                                                    <?php echo anchor($activity->object->url,character_limiter($activity->object->content,30),'target="_blank"'); ?>
                                                                    <span><?php echo !empty($activity->actor->displayName)? $activity->actor->displayName: $name; ?></span>
                                                                </div>
                                                            <!-- end: featured post -->
                                                            </div>
                                                        <?php endif; ?>
                                                
                                                        <?php endforeach; ?>
                                                        <?php else : ?>
                                                          <div class="featured_post">
                                                            <span><small>We could not retrieve your G+ activities at this time, check your Internet connection and refresh your browser or you might have to Sign up for G+</small></span>
                                                            <!-- end: featured post -->
                                                          </div>
                                                    <?php endif; ?>
                                                    
						</div>
						
						<div class="tab_content" id="recent">
							
							<!-- featured post -->
							<div class="featured_post">
								<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=223&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=binghamuni.edu.ng_755i0nndbt8c8dgkao8tmqj79s%40group.calendar.google.com&amp;color=%23875509&amp;ctz=Africa%2FLagos" style=" border-width:0 " width="188" height="223" frameborder="0" scrolling="no"></iframe>
							<!-- end: featured post -->
							</div>
							
						</div>
					</div>
				</div>
			<!-- end: tabbed content -->
			</div>
			
			<!-- testimonials -->
			<div class="module">
				<div class="module_inner">
					<h2 class="module_title">Tweets</h2>
					
					<div class="module_content">
					
						<ul class="testimonials" data-autoswitch="1" data-timeout="5">
                                                    <?php if(!empty($tweets)) : ?>
                                                        <?php foreach($tweets as $tweet) : ?>
                                                    <li data-author="<?php echo $tweet->user->name; ?>"><?php echo character_limiter($tweet->text,40); ?></li>
                                                        <?php endforeach; ?>
                                                        <?php else : ?>
                                                            <li><small>Could not retrieve your Tweets at this time.</small></li>
                                                    <?php endif;?>
						</ul>
						
					</div>
				</div>
			<!-- end: testimonials -->
			</div>
			
		<!-- end: widgets sidebar -->
		</div>