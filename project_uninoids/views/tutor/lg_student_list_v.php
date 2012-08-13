<div id="container">
	<h1>Students List for <?php echo '"' .strtoupper(expand_lg_name($learning_group_id)) . '"';?></h1>
	
	<div id="body">
	
	<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Full Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Email Address</th>
					<!-- <th style="border: 1px solid #3e3e3e; background-color: #cececa;">Grade</th>  -->
					<!-- <th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>  -->
				</tr>
			</thead>
			<tbody>
			<?php if($student_lists !== NULL) : ?>
				<?php foreach($student_lists as $student) : ?>
				    <?php echo student_list($student->student_list); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="3">No Students enrolled for this Learning Group!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('tutor/manage_lg','<< Back') ?></p>
	</div>
	
</div>