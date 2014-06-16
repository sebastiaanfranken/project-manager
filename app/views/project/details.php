<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('ProjectController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('ProjectController@getCreate');?>">Aanmaken</a></li>
			<li class="pull-right"><a href="<?php print action('ProjectController@getUpdate', array($project->id));?>">Wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Details</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Sleutel</th>
					<th>Waarde</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>Naam</td>
					<td><?php print $project->name;?></td>
				</tr>
				<tr>
					<td>Omschrijving</td>
					<td><?php print $project->description;?></td>
				</tr>
				<tr>
					<td>Geschatte uren</td>
					<td><?php print nill($project->estimated_hours, 'Geen geschatte uren');?></td>
				</tr>
				<tr>
					<td>Leden</td>
					<td><?php print print_array(Project::find($project->id)->users()->get()->toArray(), 'username');?></td>
				</tr>
				<tr>
					<td>Startdatum</td>
					<td><?php print timestamp($project->start_date, 'Geen startdatum');?></td>
				</tr>
				<tr>
					<td>Einddatum</td>
					<td><?php print timestamp($project->end_date, 'Geen einddatum');?></td>
				</tr>
				<tr>
					<td>Laatste wijziging</td>
					<td><?php print timestamp($project->updated_at, 'Geen wijzigingen', 'd-m-Y H:i:s');?></td>
				</tr>
				<tr>
					<td>Voortgang</td>
					<td><?php print Project::completion($project->id);?></td>
				</tr>
			</tbody>
		</table> <!-- /.table /.table-striped -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Taken (<?php print count($tasks);?>)</h2>
		<?php if(count($tasks) > 0) : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Naam</th>
					<th>Toegekend aan</th>
					<th>Startdatum</th>
					<th>Einddatum</th>
					<th>Voortgang</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($tasks as $task) : ?>
				<tr class="<?php print $task->completion == 100 ? 'text-muted' : '';?>">
					<td><a href="<?php print action('TaskController@getDetails', array($task->id));?>"><?php print $task->name;?></a></td>
					<td><?php print User::find($task->user_id)->username;?></td>
					<td><?php print timestamp($task->start_date, 'Geen startdatum');?></td>
					<td><?php print timestamp($task->end_date, 'Geen einddatum');?></td>
					<td><?php print $task->completion;?>%</td>
					<td>
						<a href="<?php print action('TaskController@getUpdate', array($task->id));?>">Wijzigen</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table> <!-- /.table /.table-striped -->
		<?php else : ?>
		<p>Er zijn nog geen taken. Wil je er <a href="<?php print action('TaskController@getCreate', array($project->id, Auth::user()->id));?>">een toevoegen</a>?</p>
		<?php endif;?>
	</div> <!-- /.row -->
</div> <!-- /.container -->