<div id="container">
	<h1>Tutor Details</h1>
	
	<div id="body">

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Tutor Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Curriculum</th>
				</tr>
			</thead>
			<tbody>
			<?php if($tutor_details !== NULL) : ?>
				<?php foreach($tutor_details as $tutor) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_tutor_name_from_email($tutor->tutor_email); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo _expand_curriculum_name($tutor->curriculum_id); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">Tutor details is not available to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('admin/manage_tutors','<< Back') ?></p>
	</div>
	
</div>