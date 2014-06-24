<!DOCTYPE html>

<html lang="nl">
	<head>
		<meta charset="utf-8" />
		<meta name="author" content="Sebastiaan Franken" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Projectplanner Dashboard</title>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/dashboard.css" />
	</head>

	<body>
		<div class="navbar navbar-fixed-top dashboard-navbar" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigatie</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> <!-- /.navbar-toggle -->

					<a href="<?php print action('DashboardController@getIndex');?>" class="navbar-brand">ProjectPlanner Dashboard</a>
				</div> <!-- /.navbar-header -->

				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="<?php print Request::segment(2) == 'import' ? 'active' : '';?>"><a href="<?php print action('DashboardController@getImport');?>">Importeren</a></li>
						<li class="<?php print Request::segment(2) == 'export' ? 'active' : '';?>"><a href="<?php print action('DashboardController@getExport');?>">Exporteren</a></li>
					</ul> <!-- /.nav /.nav-bar-nav -->

					<ul class="nav navbar-nav pull-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php print Auth::user()->username;?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php print URL::to('/');?>">Terug naar de applicatie</a></li>
								<li class="divider"></li>
								<li><a href="<?php print URL::to('/logout');?>">Uitloggen</a></li>
							</ul> <!-- /.dropdown-menu -->
						</li> <!-- /.dropdown -->
					</ul> <!-- /.nav /.navbar-nav /.pull-right -->
				</div> <!-- /.collapse /.navbar-collapse -->
			</div> <!-- /.container -->
		</div> <!-- /.navbar /.navbar-fixed-top /.dashboard-navbar -->

		<?php if(Session::has('message')) : ?>
		<div class="container">
			<div class="alert alert-dismissable alert-<?php print Session::get('message-type');?>">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php print Session::get('message');?>
			</div> <!-- /.alert -->
		</div> <!-- /.conatainer -->
		<?php endif;?>

		<?php print $content;?>

		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/dashboard.js"></script>
	</body>
</html>