<div id="container">
	<h1>Grades</h1>
	
	<div id="body">
		<p><strong>Available Grade(s)</strong></p> 
        <!-- a_id,a_name,a_description,a_file_url,a_start_date,a_due_date -->
		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Assessment</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Tutor</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Score</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Grade</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Certificate</th>
				</tr>
			</thead>
			<tbody>
			<?php if($grades !== NULL) : ?>
				<?php foreach($grades as $grade) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_assessment_name($grade->a_id); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_tutor_name_from_email(tutor_email_from_id(expand_tutor_id_from_lg(expand_lg_id_from_assessment($grade->a_id)))); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo $grade->score; ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo grade_from_score($grade->score,TRUE); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo certificate_status($grade->a_id,$this->session->userdata('email_address')); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="5">No Score or Grade to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>