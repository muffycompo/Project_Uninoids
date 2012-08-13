<div id="container">
	<h1>Manage Study Materials</h1>
	
	<div id="body">
		<p><strong>List of Available Study Materials</strong> | <?php echo anchor('admin/add_sm','Add Study Material'); ?></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Title</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Curriculum</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($study_materials !== NULL) : ?>
				<?php foreach($study_materials as $study) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo anchor($study->sm_url,$study->sm_title); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo _expand_curriculum_name($study->curriculum_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor('admin/sm_action/edit/' . $study->sm_id,'Edit'); ?>  | <?php echo anchor('admin/sm_action/delete/' . $study->sm_id,'Delete'); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Study Material(s) available to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>