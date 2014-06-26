<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#projects" data-toggle="tab">Projecten</a></li>
			<li><a href="#tasks" data-toggle="tab">Taken</a></li>
			<li><a href="#users" data-toggle="tab">Gebruikers</a></li>
		</ul> <!-- /.nav /.nav-tabs -->

		<div class="tab-content">
			<div class="tab-pane active" id="projects">
				<h2>
					Alle projecten
					<div class="pull-right">
						<a href="<?php print action('ProjectController@getCreate');?>" class="btn btn-info btn-sm">+</a>
					</div> <!-- /.pull-right -->
				</h2>

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
			</div> <!-- /.tabe-pane /#projects -->

			<div class="tab-pane" id="tasks">
				<h2>
					Alle taken
					<div class="pull-right">
						<a href="<?php print action('TaskController@getCreate');?>" class="btn btn-info btn-sm">+</a>
					</div> <!-- /.pull-right -->
				</h2>

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
			</div> <!-- /.tabe-pane /#tasks -->

			<div class="tab-pane" id="users">
				<h2>
					Alle gebruikers
					<div class="pull-right">
						<a href="<?php print action('DashboardController@getCreateUser');?>" class="btn btn-info btn-sm">+</a>
					</div> <!-- /.pull-right -->
				</h2>
				<?php if(count($users) > 0) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Naam</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($users as $user) : ?>
						<tr>
							<td><?php print $user->id;?></td>
							<td><?php print $user->username;?></td>
							<td>
								<a href="<?php print action('DashboardController@getUpdateUser', array($user->id)); ?>">Wijzigen</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table> <!-- /.table /.table-striped -->
				<?php else : ?>
				<p>Er zijn nog geen gebruikers.</p>
				<?php endif;?>
			</div> <!-- /.tab-pane /#users -->
		</div> <!-- /.tab-content -->
	</div> <!-- /.row -->
</div> <!-- /.container -->