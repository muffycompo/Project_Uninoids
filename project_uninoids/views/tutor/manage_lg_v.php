<div id="container">
	<h1>Manage Learning Groups</h1>
	
	<div id="body">
		<p><strong>List of Available Learning Groups</strong> | <?php echo anchor('tutor/add_lg','Add New Learning Group'); ?></p> 

		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Learning Group Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Tutor(s)</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if($learning_groups !== NULL) : ?>
				<?php foreach($learning_groups as $lg) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo $lg->lg_name; ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo $lg->tutor_id; ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo anchor('tutpr/lg_action/sl/' . $lg->lg_id,'View Students'); ?> | <?php echo anchor('tutor/lg_action/edit/' . $lg->lg_id,'Edit'); ?> | <?php echo anchor('tutor/lg_action/delete/' . $lg->lg_id,'Delete'); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Learning Groups available to display!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('dashboard','<< Back') ?></p>
	</div>
	
</div>