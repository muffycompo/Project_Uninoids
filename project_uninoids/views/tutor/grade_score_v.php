<div id="container">
	<h1>Students List for <?php echo '"' .strtoupper(expand_lg_name($lg_id)) . '"';?></h1>
	
	<div id="body">
	
	<table style="width: 800px">
	<?php echo form_open('tutor/add_grade'); ?>
	    <?php echo form_hidden('a_id', expand_assessment_id_from_lg($lg_id)); ?>
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Full Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Email Address</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Score</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>
					<!-- <th style="border: 1px solid #3e3e3e; background-color: #cececa;">Action</th>  -->
				</tr>
			</thead>
			<tbody>
			<?php if($student_lists !== NULL) : ?>
				<?php foreach($student_lists as $student) : ?>
				    <?php echo student_grade_list($student->student_list, $lg_id); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="4">No Scores entered for this assessment!</td>
				</tr>
			<?php endif; ?>
			</tbody>
			
		</table>
		<?php echo form_submit('submit_grade','Save Scores'); ?>
      <?php echo form_close(); ?>
		<p><?php echo anchor('tutor/manage_grades','<< Back') ?></p>
	</div>
	
</div>