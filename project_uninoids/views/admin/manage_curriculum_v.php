<div id="container">
	<h1>Manage Curriculum</h1>
	
	<div id="body">
		<p><strong>List of Available Curriculum</strong> | <?php echo anchor('admin/add_curriculum','Add New Curriculum'); ?></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Curriculum Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Status</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($curriculums !== NULL) : ?>
				<?php foreach($curriculums as $curriculum) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo $curriculum->curriculum_name; ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo expand_curriculum_status($curriculum->status); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor('admin/curriculum_action/edit/' . $curriculum->curriculum_id,'Edit'); ?> | <?php echo anchor('admin/curriculum_action/delete/' . $curriculum->curriculum_id,'Delete'); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No curriculums available to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>