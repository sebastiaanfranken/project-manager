<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php print action('UserController@getIndex');?>">Profiel</a></li>
			<li><a href="<?php print action('UserController@getPassword');?>">Wachtwoord wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Profiel</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Sleutel</th>
					<th>Waarde</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>Gebruikersnaam</td>
					<td><?php print $user->username;?></td>
				</tr>
				<tr>
					<td>Geregistreerd op</td>
					<td><?php print timestamp($user->created_at, 'Niet bekend');?></td>
				</tr>
				<tr>
					<td>Laatste wijziging op</td>
					<td><?php print timestamp($user->updated_at, 'Geen wijzigingen');?></td>
				</tr>
			</tbody>
		</table> <!-- /.table /.table-striped -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Taken</h2>
		<?php if(count($tasks) > 0) : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Naam</th>
					<th>Project</th>
					<th>Startdatum</th>
					<th>Einddatum</th>
					<th>Voortgang</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($tasks as $task) : ?>
				<tr>
					<td><?php print $task->id;?></td>
					<td><?php print $task->name;?></td>
					<td><?php print Project::find($task->project_id)->name;?></td>
					<td><?php print timestamp($task->start_date, 'Geen startdatum');?></td>
					<td><?php print timestamp($task->end_date, 'Geen einddatum');?></td>
					<td><?php print $task->completion;?>%</td>
					<td>
						<a href="<?php print action('TaskController@getDetails', array($task->id));?>">Details</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table> <!-- /.table /.table-striped -->
		<?php else : ?>
		<p>Er zijn nog geen taken toegewezen aan je. Wil je er nu <a href="<?php print action('TaskController@getCreate', array($user->id));?>">een toevoegen</a>?</p>
		<?php endif;?>
	</div> <!-- /.row -->

	<div class="row">
		<h2>Projecten</h2>
		<?php if(count($projects) > 0) : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Naam</th>
					<th>Leden</th>
					<th>Startdatum</th>
					<th>Einddatum</th>
					<th>Voortgang</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($projects as $project) : ?>
				<tr>
					<td><?php print $project->id;?></td>
					<td><?php print $project->name;?></td>
					<td><?php print print_array( Project::find($project->id)->users()->get()->toArray(), 'username' );?></td>
					<td><?php print timestamp($project->start_date, 'Geen startdatum');?></td>
					<td><?php print timestamp($project->end_date, 'Geen einddatum');?></td>
					<td><?php print Project::completion($project->id);?></td>
					<td>
						<a href="<?php print action('ProjectController@getDetails', array($project->id));?>">Details</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table> <!-- /.table /.table-striped -->
		<?php else : ?>
		<p>Er zijn nog geen projecten toegewezen aan ja. Wil je er nu <a href="<?php print action('ProjectController@getCreate');?>">een toevoegen</a>?</p>
		<?php endif;?>
	</div> <!-- /.row -->

	<div class="row">
		<h2>Reacties</h2>
		<?php if($user->comments()->count() > 0) : ?>
		<table class="table table-striped">

		</table> <!-- /.table /.table-striped -->
		<?php else : ?>
		<p>Er zijn nog geen reacties van je.</p>
		<?php endif;?>
	</div> <!-- /.row -->
</div> <!-- /.container -->