<div id="container">
	<h1>Create Tutors</h1>

	<div id="body">
		<table style="width: 500px;">
			<thead>
				<tr style="text-align: left;">
					<th>1) Curriculum Selection</th>
					<th>2) Tutors</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php echo form_open('admin/add_tutors'); ?>
					<td>
					<?php if($curriculums !== NULL) : ?>
						<?php foreach($curriculums as $curriculum) : ?>
							<p><?php echo form_checkbox('curriculum[]', set_value('curriculum', $curriculum->curriculum_id) ); ?> &nbsp;<?php echo $curriculum->curriculum_name; ?></p>
						<?php endforeach; ?>
					<?php endif; ?>
					</td>
					<td>
						<p>
							<label>Email address:</label><br />
							<?php echo form_input('tutor_email'); ?>
						</p>
						<p>
							<?php echo form_submit('submit_tutor','Create Tutor'); ?>
						</p>
					</td>
					<?php echo form_close(); ?>
				</tr>
			</tbody>
		</table>		
		<p><?php echo anchor('admin/manage_tutors','<< Back') ?></p>
	</div>
</div>