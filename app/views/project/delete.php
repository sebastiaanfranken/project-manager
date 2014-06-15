<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('ProjectController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('ProjectController@getCreate');?>">Aanmaken</a></li>
			<li class="pull-right"><a href="<?php print action('ProjectController@getUpdate', array($projectid));?>">Wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Project verwijderen</h2>
		<?php if($tasks->count()) : ?>
		<p>Dit project kan (nog) niet verwijderd worden. Sommige taken zijn nog niet afgerond:</p>
		<ul>
			<?php foreach($tasks->get() as $task) : ?>
			<li><a href="<?php print action('TaskController@getDetails', array($task->id));?>"><?php print $task->name;?></a></li>
			<?php endforeach;?>
		</ul>
		<?php else : ?>
		<p>Weet je zeker dat je dit project wilt verwijderen?</p>
		<?php print Form::open(array('class' => 'form-horizontal', 'role' => 'form'));?>
		<?php print Form::submit('Verwijderen', array('class' => 'btn btn-danger'));?>
		<a href="<?php print action('ProjectController@getDetails', array($projectid));?>" class="btn btn-default">Terug</a>
		<?php print Form::close();?>
		<?php endif;?>
	</div> <!-- /.row -->
</div> <!-- /.container -->