<div id="container">
	<h1>Manage Certificates</h1>
	
	<div id="body">
		<p><strong>Learning Group Certificates</strong></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Learning Group</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Assessment</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($certs !== NULL) : ?>
				<?php foreach($certs as $cert) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_lg_name(expand_lg_id_from_assessment($cert->a_id)); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo expand_assessment_name($cert->a_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;">
					<?php if($cert->status == 1) { ?>
					    <?php echo anchor('tutor/cert_action/show/' . $cert->a_id,'Issue Certificates'); ?>
					<?php } else if($cert->status == 2) {?>
					    <?php echo anchor('tutor/cert_action/hide/' . $cert->a_id,'Retrieve Certificates'); ?>
					<?php } ?>
					
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="4">No Certificates available to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>