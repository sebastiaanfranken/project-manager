<div class="container">
	<div class="row">
		<h2>Weet je het zeker?</h2>
		<p>Het verwijderen van alle taken, projecten gebruikers is iets wat je <strong>niet ongedaan</strong> kan maken!</p>
		<?php print Form::open(array('class' => 'form-horizontal', 'role' => 'form'));?>
			<div class="form-group">
				<div class="col-sm-12">
					<?php print Form::submit('Ik weet het zeker', array('class' => 'btn btn-danger'));?>
					<a href="<?php print URL::to('/');?>" class="btn btn-default">Nee!</a>
				</div> <!-- /.col-sm-12 -->
			</div> <!-- /.form-group -->
		<?php print Form::close();?>
	</div> <!-- /.row -->
</div> <!-- /.container -->