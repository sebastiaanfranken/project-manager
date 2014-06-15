<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('TaskController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('TaskController@getCreate');?>">Aanmaken</a></li>
			<li class="pull-right"><a href="<?php print action('TaskController@getUpdate', array($task->id));?>">Wijzigen</a></li>
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
					<td>Gebruiker</td>
					<td><?php print $user;?></td>
				</tr>
				<tr>
					<td>Project</td>
					<td><?php print $project;?></td>
				</tr>
				<tr>
					<td>Naam</td>
					<td><?php print $task->name;?></td>
				</tr>
				<tr>
					<td>Voortgang</td>
					<td><?php print $task->completion;?>%</td>
				</tr>
				<tr>
					<td>Startdatum</td>
					<td><?php print timestamp($task->start_date, 'Geen startdatum');?></td>
				</tr>
				<tr>
					<td>Einddatum</td>
					<td><?php print timestamp($task->end_date, 'Geen einddatum');?></td>
				</tr>
				<tr>
					<td>Laatste wijziging</td>
					<td><?php print timestamp($task->updated_at, 'Geen laatste wijzigingen', 'd-m-Y H:i:s');?></td>
				</tr>
			</tbody>
		</table> <!-- /.table /.table-striped -->
	</div> <!-- /.row -->
</div> <!-- /.container -->