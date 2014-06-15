<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php print action('TaskController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('TaskController@getCreate');?>">Aanmaken</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Taken</h2>
		<?php if(count($tasks) > 0) : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Naam</th>
					<th>Voortgang</th>
					<th>Project</th>
					<th>Startdatum</th>
					<th>Einddatum</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($tasks as $task) : ?>
				<tr>
					<td><?php print $task->id;?></td>
					<td><?php print $task->name;?></td>
					<td><?php print $task->completion;?>%</td>
					<td><a href="<?php print action('ProjectController@getDetails', array($task->project_id));?>"><?php print Project::find($task->project_id)->name;?></a></td>
					<td><?php print timestamp($task->start_date, 'Geen startdatum');?></td>
					<td><?php print timestamp($task->end_date, 'Geen einddatum');?></td>
					<td>
						<a href="<?php print action('TaskController@getDetails', array($task->id));?>">Details</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table> <!-- /.table /.table-striped -->
		<?php print $tasks->links();?>
		<?php else : ?>
		<p>Er zijn nog geen taken. Wil je er <a href="<?php print action('TaskController@getCreate');?>">een toevoegen</a>?</p>
		<?php endif;?>
	</div> <!-- /.row -->
</div> <!-- /.container -->