<!DOCYTPE html>

<html lang="nl">
	<head>
		<meta charset="utf-8" />
		<meta name="author" content="Sebastiaan Franken" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Projectplanner</title>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/layout.css" />
	</head>

	<body>
		<div class="navbar navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigatie</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> <!-- /.navbar-toggle -->

					<a href="<?php print URL::to('/');?>" class="navbar-brand">ProjectPlanner</a>
				</div> <!-- /.navbar-header -->
					
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="<?php print Request::segment(1) == 'project' ? 'active' : '';?>"><a href="<?php print action('ProjectController@getIndex');?>">Projecten</a></li>
						<li class="<?php print Request::segment(1) == 'task' ? 'active' : ''; ?>"><a href="<?php print action('TaskController@getIndex');?>">Taken</a></li>
					</ul> <!-- /.nav /.navbar-nav -->

					<?php if(Auth::check()) : ?>
					<ul class="nav navbar-nav pull-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php print Auth::user()->username;?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php print action('UserController@getIndex');?>">Mijn profiel</a></li>
								<li><a href="<?php print action('UserController@getPassword');?>">Wachtwoord wijzigen</a></li>
								<?php if(Auth::user()->role == 'admin') : ?>
								<li class="divider"></li>
								<li><a href="<?php print action('UserController@getUsers');?>">Gebruikersbeheer</a></li>
								<?php endif;?>
								<li class="divider"></li>
								<li><a href="<?php print action('UserController@getExport');?>">Gegevens exporteren</a></li>
								<li><a href="<?php print action('UserController@getImport');?>">Gegevens importeren</a></li>
								<li class="divider"></li>
								<li><a href="<?php print URL::to('logout');?>">Uitloggen</a></li>
							</ul> <!-- /.dropdown-menu -->
						</li> <!-- /.dropdown -->
					</ul> <!-- /.nav /.navbar-nav /.pull-right -->
					<?php endif;?>
				</div> <!-- /.collapse /.navbar-collapse -->
			</div> <!-- /.container -->
		</div> <!-- /.navbar /.navbar-fixed-top -->

		<?php if(Session::has('message')) : ?>
		<div class="container">
			<div class="alert alert-info">
				<?php print Session::get('message');?>
			</div> <!-- /.alert /.alert-info -->
		</div> <!-- /.container -->
		<?php endif;?>

		<?php print $content;?>

		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/script.js"></script>
	</body>
</html>