<!DOCTYPE html>

<html lang="nl">
	<head>
		<meta charset="utf-8" />
		<meta name="author" content="Sebastiaan Franken" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Projectplanner</title>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/login.css" />
	</head>

	<body>
		<div class="container">
			<?php print Form::open(array('class' => 'form-signin', 'role' => 'form'));?>
			<h2 class="form-signin-heading">Login</h2>
			<?php
			print Form::text('username', Input::old('username'), array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Gebruikersnaam', 'autofocus' => 'autofocus'));
			print Form::password('password', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Wachtwoord'));
			print Form::submit('Inloggen', array('class' => 'btn btn-lg btn-info btn-block'));
			print Form::close();
			?>
		</div> <!-- /.container -->
	</body>
</html>