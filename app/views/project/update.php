<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('ProjectController@getIndex');?>">Overzicht</a></li>
			<li><a href="<?php print action('ProjectController@getCreate');?>">Aanmaken</a></li>
			<li class="active pull-right"><a href="<?php print action('ProjectController@getUpdate', array($project->id));?>">Wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8">
			<h2>Project <em><?php print $project->name;?></em> wijzigen</h2>

			<?php if(isset($errors) && count($errors) > 0) : ?>
			<div class="alert alert-info">
				<ul>
					<?php foreach($errors->all() as $error) : ?>
					<li><?php print $error;?></li>
					<?php endforeach;?>
				</ul>
			</div> <!-- /.alert /.alert-info -->
			<?php endif;?>

			<?php print Form::model($project, array('class' => 'form-horizontal', 'role' => 'form'));?>
			<div class="form-group">
				<?php print Form::label('name', 'Naam', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('name', Input::old('name'), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('description', 'Omschrijving', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'required' => 'required', 'rows' => 6));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<?php /*
			<div class="form-group">
				<?php print Form::label('members', 'Leden', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php foreach($users as $id => $username) : ?>
					<div class="checkbox">
						<label>
							<?php print Form::checkbox('members[]', $id, User::isProjectMember($id, $project->id)) . ' ' . $username;?>
						</label>
					</div> <!-- /.checkbox -->
					<?php endforeach;?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			*/ ?>
			<div class="form-group">
				<?php print Form::label('start_date', 'Startdatum', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('start_date', Input::old('start_date', timestamp($project->start_date, null, 'd-m-Y')), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('end_date', 'Einddatum', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('end_date', Input::old('end_date', timestamp($project->end_date, null, 'd-m-Y')), array('class' => 'form-control'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<?php print Form::submit('Wijzigen', array('class' => 'btn btn-info'));?>
					<?php if(count($tasks) > 0) : ?>
					<a href="<?php print action('ProjectController@getDelete', array($project->id));?>" class="btn btn-danger">Verwijderen</a>
					<?php endif;?>
				</div> <!-- /.col-sm-offset-2 /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<?php print Form::close();?>
		</div> <!-- /.col-sm-8 /.col-md-8 /.col-lg-8 -->

		<aside class="col-sm-4 col-md-4 col-lg-4">
			<h2>Hulp</h2>
			<p>Met dit formulier, met de volgende velden, kun je een bestaand <em>project</em> wijzigen.</p>
			<ul>
				<li><strong>Naam</strong>. De naam van het project. Hou het kort en bondig</li>
				<li><strong>Omschrijving</strong>. De omschrijving. Hier mag je meer info kwijt</li>
				<li><strong>Leden</strong>. Wie zijn er onderdeel van dit project?</li>
				<li><strong>Startdatum</strong>. Wanneer beginnen we?</li>
				<li><strong>Einddatum</strong>. Wanneer mag het af zijn?</li>
			</ul>
		</aside> <!-- /.col-sm-4 /.col-md-4 /.col-lg-4 -->
	</div> <!-- /.row -->
</div> <!-- /.cotainer -->