<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li><a href="<?php print action('UserController@getUsers');?>">Overzicht</a></li>
			<li><a href="<?php print action('UserController@getCreate');?>">Aanmaken</a></li>
			<li class="pull-right"><a href="<?php print action('UserController@getUpdate', array($user->id));?>">Wijzigen</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Gebruiker <em><?php print $user->username;?></em> verwijderen?</h2>
		<?php print Form::open(array('class' => 'form-horizontal', 'role' => 'form'));?>
		<div class="form-group">
			<div class="col-sm-12">
				<?php print Form::submit('Verwijderen', array('class' => 'btn btn-danger'));?>
				<a href="<?php print action('UserController@getUsers');?>" class="btn btn-default">Terug</a>
			</div> <!-- /.col-sm-12 -->
		</div> <!-- /.form-group -->
		<?php print Form::close();?>
	</div> <!-- /.row -->
</div> <!-- /.container -->