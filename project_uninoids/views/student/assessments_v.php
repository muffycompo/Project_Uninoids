<div id="container">
	<h1>Assessments</h1>
	
	<div id="body">
		<p><strong>List of Available Assessment(s)</strong></p> 
        <!-- a_id,a_name,a_description,a_file_url,a_start_date,a_due_date -->
		<table style="width: 960px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Title</th>
<!--					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Description</th>-->
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Tutor</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Learning Group</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Start Date</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Due Date</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($assessments !== NULL) : ?>
				<?php foreach($assessments as $assessment) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo $assessment->a_name; ?></td>
					<!--<td style="border: 1px solid #3e3e3e;"><?php //echo $assessment->a_description; ?></td>-->
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_tutor_name_from_email(tutor_email_from_id(expand_tutor_id_from_lg(expand_lg_id_from_assessment($assessment->a_id)))); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_lg_name(expand_lg_id_from_assessment($assessment->a_id)); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo uninoids_date($assessment->a_start_date); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo uninoids_date($assessment->a_due_date); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor($assessment->a_file_url,'View','target="_blank"'); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="7">No Active Assessment(s) to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>