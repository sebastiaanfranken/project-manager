<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php print action('ProjectController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('ProjectController@getCreate');?>">Aanmaken</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
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
					<td><?php print print_array(Project::find($project->id)->users()->get()->toArray(), 'username');?></td>
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
		<?php print $projects->links();?>
		<?php else : ?>
		<p>Er zijn nog geen projecten. Wil je er <a href="<?php print action('ProjectController@getCreate');?>">een toevoegen</a>?</p>
		<?php endif;?>
	</div> <!-- /.row -->
</div> <!-- /.container -->