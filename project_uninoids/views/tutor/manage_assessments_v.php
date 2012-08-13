<div id="container">
	<h1>Manage Assessments</h1>
	
	<div id="body">
		<p><strong>List of Assessments</strong> | <?php echo anchor('tutor/add_assessments_html','Create New Assessment'); ?> | <?php echo anchor('tutor/add_assessments_upload','Upload New Assessment'); ?></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Title</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Learning Group</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($assessments !== NULL) : ?>
				<?php foreach($assessments as $assessment) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo $assessment->a_name; ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo expand_lg_name($assessment->lg_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor($assessment->a_file_url,'View','target="_blank"'); ?>  | <?php echo anchor('tutor/assessment_action/delete/' . $assessment->a_id,'Delete'); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Assessments available to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><em><strong>Note:</strong> You can only create one assessment per learning group</em></p>
		
		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>