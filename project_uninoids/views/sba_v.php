<div id="container">
	<h1>Assessments</h1>

	<div id="body">
		<p><strong>List of Available Assessments</strong></p>
		<?php if(! empty($drive_files)) : ?>
			<?php foreach($drive_files->items as $assessment) : ?>
				<!--<p><?php echo anchor($assessment->alternateLink, $assessment->title); ?></p>-->
				<p><?php echo anchor($assessment->alternateLink, $assessment->title,'target="_blank"'); ?></p>
			<?php endforeach; ?>
		<?php endif; ?>
			
		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>