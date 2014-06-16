<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('UserController@getIndex');?>">Profiel</a></li>
			<li class="active"><a href="<?php print action('UserController@getPassword');?>">Wachtwoord wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Wachtwoord wijzigen</h2>
		<div class="alert alert-warning">
			<p><strong>Let op</strong>: na het wijzigen van je wachtwoord word je uitgelogd.</p>
		</div> <!-- /.alert /.alert-warning -->

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
				<?php print Form::label('password', 'Huidig wachtwoord', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::password('password', array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('new_password', 'Nieuw wachtwoord', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::password('new_password', array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<?php print Form::label('new_password_check', 'Nieuw wachtwoord controle', array('class' => 'col-sm-2 control-label'));?>
				<div class="col-sm-10">
					<?php print Form::password('new_password_check', array('class' => 'form-control', 'required' => 'required'));?>
				</div> <!-- /.col-sm-10 -->
			</div> <!-- /.form-group -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<?php print Form::submit('Wijzigen', array('class' => 'btn btn-info'));?>
					<?php print Form::reset('Wissen', array('class' => 'btn btn-default'));?>
				</div> <!-- /.col-sm-offset-2 /.col-sm-10 -->
			</div> <!-- /.form-group -->
		<?php print Form::close();?>
	</div> <!-- /.row -->
</div> <!-- /.container -->