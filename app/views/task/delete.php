<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('TaskController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('TaskController@getCreate');?>">Aanmaken</a></li>
			<li class="pull-right"><a href="<?php print action('TaskController@getUpdate', array($task->id));?>">Wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Taak verwijderen</h2>
		<?php if($task->completion < 100) : ?>
		<p>Deze taak kan niet verwijderd worden. Alleen taken die zijn afgerond kunnen verwijderd worden.</p>
		<p><a href="<?php print action('TaskController@getDetails', array($task->id));?>" class="btn btn-default">Terug</a></p>
		<?php else : ?>
		<p>Weet je zeker dat je deze taak wilt verwijderen?</p>
		<?php print Form::open(array('class' => 'form-horizontal', 'role' => 'form'));?>
			<?php print Form::submit('Verwijderen', array('class' => 'btn btn-danger'));?>
			<a href="<?php print action('TaskController@getDetails', array($task->id));?>" class="btn btn-default">Terug</a>
		<?php print Form::close();?>
		<?php endif;?>
	</div> <!-- /.row -->
</div> <!-- /.container -->