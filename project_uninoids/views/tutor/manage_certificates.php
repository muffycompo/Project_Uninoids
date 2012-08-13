<div id="container">
	<h1>Manage Certficates</h1>
	
	<div id="body">
		<p><strong>Learning Group Certficates</strong></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Learning Group</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Certificates Issued</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($certificates !== NULL) : ?>
				<?php foreach($certificates as $cert) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_assessment_name($grade->a_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo expand_lg_name($grade->lg_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor('tutor/grade_action/scores/'. $grade->lg_id,'Scores'); ?> | <?php echo anchor('tutor/grade_action/grades/'. $grade->a_id,'View Grades'); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Certificate has been issued!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>