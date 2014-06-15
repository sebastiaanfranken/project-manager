<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('TaskController@getIndex');?>">Overzicht</a></li>
			<li class="active"><a href="<?php print action('TaskController@getCreate');?>">Aanmaken</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8">
			<h2>Taak aanmaken</h2>
			
			<?php if(isset($errors) && count($errors) > 0) : ?>
			<div class="alert alert-warning">
				<ul>
					<?php foreach($errors->all() as $error) : ?>
					<li><?php print $error;?></li>
					<?php endforeach;?>
				</ul>
			</div> <!-- /.alert /.alert-warning -->
			<?php endif;?>

			<?php print Form::open(array('class' => 'form-horizontal', 'role' => 'form'));?>
			<div class="form-group">
				<?php print Form::label('project_id', 'Project', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::select('project_id', $projects, Input::old('project_id'), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('user_id', 'Gebruiker', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::select('user_id', $users, Input::old('user_id'), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('name', 'Naam', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('name', Input::old('name'), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('description', 'Omschrijving', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows' => 6, 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('start_date', 'Startdatum', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('start_date', Input::old('start_date', timestamp('now')), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('end_date', 'Einddatum', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('end_date', Input::old('end_date'), array('class' => 'form-control'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<?php print Form::submit('Toevoegen', array('class' => 'btn btn-info'));?>
					<?php print Form::reset('Opnieuw', array('class' => 'btn btn-default'));?>
				</div> <!-- /.col-sm-offset-2 /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<?php print Form::close();?>
		</div> <!-- /.col-sm-8 /.col-md-8 /.col-lg-8 -->

		<aside class="col-sm-4 col-md-4 col-lg-4">
			<h2>Hulp</h2>
			<p>Met dit formulier, met de volgende velden, kun je een nieuwe <em>taak</em> aanmaken.</p>
			<ul>
				<li><strong>Project</strong>: Welk project valt deze taak onder?</li>
				<li><strong>Gebruiker</strong>: Welke gebruiker is verantwoordelijk voor deze taak?</li>
				<li><stong>Naam</stong>: de naam van de taak</li>
				<li><strong>Startdatum</strong>: De startdatum van de taak</li>
				<li><strong>Einddatum</strong>: De einddatum van de taak. Is niet verplicht.</li>
			</ul>
		</aside> <!-- /.col-sm-4 /.col-md-4 /.col-lg-4 -->
	</div> <!-- /.row -->
</div> <!-- /.container -->