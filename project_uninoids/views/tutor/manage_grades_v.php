<div id="container">
	<h1>Manage Grades</h1>
	
	<div id="body">
		<p><strong>Grade Assessments</strong></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Assessment</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Learning Group</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($grades !== NULL) : ?>
				<?php foreach($grades as $grade) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_assessment_name($grade->a_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo expand_lg_name($grade->lg_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor('tutor/grade_action/scores/'. $grade->lg_id,'Scores'); ?> | <?php echo anchor('tutor/grade_action/grades/'. $grade->a_id,'View Grades'); ?><?php //echo certificate_link($grade->a_id) ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Assessment has been graded yet!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>