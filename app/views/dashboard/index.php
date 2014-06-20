<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<h2>Alle projecten</h2>
			<?php if(count($projects) > 0) : ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Naam</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($projects as $project) : ?>
					<tr>
						<td><?php print $project->id;?></td>
						<td><a href="<?php print action('ProjectController@getDetails', array($project->id));?>"><?php print $project->name;?></a></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table> <!-- /.table /.table-striped -->
			<?php else : ?>
			<p>Er zijn nog geen projecten.</p>
			<?php endif;?>
		</div> <!-- /.col-sm-4 /.col-md-4 /.col-lg-4 -->

		<div class="col-sm-4 col-md-4 col-lg-4">
			<h2>Alle taken</h2>
			<?php if(count($tasks) > 0) : ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Naam</th>
						<th>Project</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($tasks as $task) : ?>
					<tr>
						<td><?php print $task->id;?></td>
						<td><a href="<?php print action('TaskController@getDetails', array($task->id));?>"><?php print $task->name;?></a></td>
						<td><a href="<?php print action('ProjectController@getDetails', array($task->project_id));?>"><?php print Project::find($task->project_id)->name;?></a></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table> <!-- /.table /.table-striped -->
			<?php else : ?>
			<p>Er zijn nog geen taken.</p>
			<?php endif;?>
		</div> <!-- /.col-sm-4 /.col-md-4 /.col-lg-4 -->
	</div> <!-- /.row -->
</div> <!-- /.container -->