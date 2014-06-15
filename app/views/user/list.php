<div class="container">
	<div class="row">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php print action('UserController@getUsers');?>">Overzicht</a></li>
			<li><a href="<?php print action('UserController@getCreate');?>">Aanmaken</a></li>
		</ul> <!-- /.nav /.nav-tabs -->
	</div> <!-- /.row -->

	<div class="row">
		<h2>Gebruikers</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Gebruikersnaam</th>
					<th>Rol</th>
					<th>Aantal taken</th>
					<th>Aantal projecten</th>
					<th>Geregistreerd op</th>
					<th>Laatste wijziging</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($users as $user) : ?>
				<tr>
					<td><?php print $user->id;?></td>
					<td><?php print $user->username;?></td>
					<td><?php print $user->role;?></td>
					<td><?php print Task::where('user_id', '=', $user->id)->count();?></td>
					<td><?php print User::find($user->id)->projects()->count();?></td>
					<td><?php print timestamp($user->created_at);?></td>
					<td><?php print timestamp($user->updated_at, 'Nog geen wijzigingen');?></td>
					<td>
						<a href="<?php print action('UserController@getUpdate', array($user->id));?>">Wijzigen</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table> <!-- /.table /.table-striped -->
	</div> <!-- /.row -->
</div> <!-- /.container -->