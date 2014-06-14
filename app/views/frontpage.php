<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6">
			<h2>Taken</h2>
			<?php if(count($tasks) > 0) : ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Taak</th>
						<th>Startdatum</th>
						<th>Einddatum</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($tasks as $task) : ?>
					<tr>
						<td><a href="<?php print action('TaskController@getDetails', array($task->id));?>"><?php print $task->name;?></a></td>
						<td><?php print timestamp($task->start_date, 'Geen startdatum');?></td>
						<td><?php print timestamp($task->end_date, 'Geen einddatum');?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table> <!-- /.table /.table-striped -->
			<?php else : ?>
			<p>Zo te zien zijn er nog geen <em>taken</em>. Wil je er <a href="<?php print action('TaskController@getCreate');?>">een toevoegen</a>?</p>
			<?php endif;?>
		</div> <!-- /.col-sm-6 /.col-md-6 /.col-lg-6 -->

		<div class="col-sm-6 col-md-6 col-lg-6">
			<h2>Projecten</h2>
			<?php if(count($projects) > 0) : ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Naam</th>
						<th>Startdatum</th>
						<th>Einddatum</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($projects as $project) : ?>
					<tr>
						<td><a href="<?php print action('ProjectController@getDetails', array($project->id));?>"><?php print $project->name;?></a></td>
						<td><?php print timestamp($project->start_date, 'Geen startdatum');?></td>
						<td><?php print timestamp($project->end_date, 'Geen einddatum');?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table> <!-- /.table /.table-striped -->
			<?php else : ?>
			<p>Zo te zien zijn er nog geen <em>projecten</em>. Wil je er <a href="<?php print action('ProjectController@getCreate');?>">een toevoegen</a>?</p>
			<?php endif;?>
		</div> <!-- /.col-sm-6 /col-md-6 /.col-lg-6 -->
	</div> <!-- /.row -->
</div> <!-- /.container -->