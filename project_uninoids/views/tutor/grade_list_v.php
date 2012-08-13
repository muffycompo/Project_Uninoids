<div id="container">
	<h1>Student Grades for "<?php echo strtoupper(expand_lg_name(expand_lg_id_from_assessment(($a_id)))); ?>"</h1>
	
	<div id="body">
	    <p>
	    <?php if(result_status($a_id) == 2) { ?>
            <?php echo anchor('tutor/result_visibity/1_' . $a_id,'Make Result Available to Students')?>
			<?php } else if(result_status($a_id) == 1) { ?>
			    <?php echo anchor('tutor/result_visibity/2_' . $a_id,'Make Result Unavailable to Students')?>
		<?php } ?>
	    </p>
		<table style="width: 800px">
			<thead>
				<tr>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Student Name</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Email Address</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Assessment</th>
					<th style="border: 1px solid #3e3e3e; background-color: #cececa;">Grade</th>
				</tr>
			</thead>
			<tbody>
			<?php if($student_grade !== NULL) : ?>
				<?php foreach($student_grade as $grade) : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_tutor_name_from_email($grade->student_email); ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo $grade->student_email; ?></td>
					<td style="border: 1px solid #3e3e3e;"><?php echo expand_assessment_name($grade->a_id); ?></td>
					<td style="border: 1px solid #3e3e3e; text-align: center;"><?php echo grade_from_score($grade->score); ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="border: 1px solid #3e3e3e;" colspan="5">No grades available for this assessment!</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<p><?php echo anchor('tutor/manage_grades','<< Back') ?></p>
	</div>
	
</div>