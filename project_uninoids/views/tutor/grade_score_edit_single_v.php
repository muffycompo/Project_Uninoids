<div id="container">
	<h1>Edit Score</h1>

	<div id="body">
        <?php if($student_lists !== NULL) : ?>
			<?php foreach($student_lists as $student) : ?>	
        		<p><?php echo form_open('tutor/add_grade'); ?></p>
        		
        		<p>
        			<label>Score <span style="color: red;">*</span></label><br />
        			<?php echo form_input('score', set_value('score',$student->score)); ?>
        			<?php echo form_hidden('a_id', $student->a_id); ?>
        			<?php echo form_hidden('student_email', $student->student_email); ?>
        		</p>
        		
        		<p><?php echo form_submit('submit_grade_edit','Update Score'); ?></p>
        		
        		<p><?php echo form_close(); ?></p>
		    <?php endforeach; ?>
		    <?php else : ?>
		    <p>No score has been entered for this student!</p>
		  <?php endif; ?>
		<p><?php echo anchor('tutor/grade_action/scores/'.$lg_id,'<< Cancel') ?></p>
	</div>
</div>