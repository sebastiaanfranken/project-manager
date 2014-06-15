<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('UserController@getUsers');?>">Overzicht</a></li>
			<li><a href="<?php print action('UserController@getCreate');?>">Aanmaken</a></li>
			<li class="pull-right active"><a href="<?php print action('UserController@getUpdate', array($user->id));?>">Wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Gebruiker <em><?php print $user->username;?></em> wijzigen</h2>

		<?php if(isset($errors) && count($errors) > 0) : ?>
		<div class="alert alert-warning">
			<ul>
				<?php foreach($errors->all() as $error) : ?>
				<li><?php print $error;?></li>
				<?php endforeach;?>
			</ul>
		</div> <!-- /.alert /.alert-warning -->
		<?php endif;?>

		<?php print Form::model($user, array('class' => 'form-horizontal', 'role' => 'form'));?>
			<div class="form-group">
				<?php print Form::label('username', 'Gebruikersnaam', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::text('username', Input::old('username'), array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('role', 'Rol', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::select('role', array('admin' => 'Beheerder', 'user' => 'Gebruiker'), $user->role, array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('passsword', 'Wachtwoord', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::password('password', array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('password_check', 'Wachtwoord (controle)', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::password('password_check', array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<?php print Form::submit('Wijzigen', array('class' => 'btn btn-info'));?>
					<a href="<?php print action('UserController@getUsers');?>" class="btn btn-default">Terug</a>
					<?php if($user->id != Auth::user()->id && $user->id != 1) : ?>
					<a href="<?php print action('UserController@getDelete', array($user->id));?>" class="pull-right btn btn-danger">Verwijderen</a>
					<?php endif;?>
				</div> <!-- /.col-sm-offset-2 /.col-sm-10 -->
			</div> <!-- /.form-group -->
		<?php print Form::close();?>
	</div> <!-- /.row -->
</div> <!-- /.container -->