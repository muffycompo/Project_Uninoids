<div id="container">
	<h1>Study Materials</h1>

	<div id="body">
		<p><strong>List of Available Materials</strong></p>
		<?php if($materials !== NULL) : ?>
			<?php foreach($materials as $material) : ?>
        		<p><?php echo anchor($material->sm_url,$material->sm_title,'target="_blank"'); ?></p>
        	<?php endforeach; ?>
		<?php else : ?>
				<p>No Study Materials available to display!</p>
		<?php endif; ?>
		 <p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>