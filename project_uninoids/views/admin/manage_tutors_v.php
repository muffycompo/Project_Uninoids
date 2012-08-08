<div id="container">
	<h1>Manage Tutors</h1>

	<div id="body">
		<p><strong>List of Available Tutors</strong> | <?php echo anchor('admin/add_tutors','Add New Tutor'); ?></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Tutor Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Curriculum(s)</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($tutors !== NULL) : ?>
				<?php $i = 0; ?>
				<?php foreach($tutors as $tutor) : ?>
					<?php if(is_valid_tutor($tutor->tutor_email)) : ?>
						<tr>
							<td style="border: 1px solid #3e3e3e;"><?php echo expand_tutor_name_from_email($tutor->tutor_email); ?></td>
							<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo expand_tutor_curriculum_list($tutor->tutor_email); ?></td>
							<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor('admin/tutor_action/details/' .format_uri_email($tutor->tutor_email,'@'),'View details','target="_blank"'); ?> | <?php echo anchor('admin/tutor_action/delete/' . format_uri_email($tutor->tutor_email,'@'),'Delete'); ?></td>
						</tr>
					<?php else : ?>
						<?php $t = $i++; ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if($t > 0) : ?>
					<tr>
						<td style="border: 1px solid #3e3e3e;" colspan="3">No Tutors has been added yet!</td>
					</tr>
				<?php endif; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Tutors has been added yet!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>