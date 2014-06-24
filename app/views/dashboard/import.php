<div class="container">
	<div class="row">
		<h2>Importeren</h2>
		<?php print Form::open(array('class' => 'form-horizontal', 'roĺe' => 'form'));?>
		<div class="form-group">
			<?php print Form::label('type', 'Type', array('class' => 'col-sm-2 control-label'));?>
			<div class="col-sm-10">
				<?php print Form::select('type', $types, 'all', array('class' => 'form-control'));?>
			</div> <!-- /.col-sm-10 -->
		</div> <!-- /.from-group -->
		<div class="form-group">
			<?php print Form::label('file', 'Bestand', array('class' => 'col-sm-2 control-label'));?>
			<div class="col-sm-10">
				<?php print Form::file('file', array('class' => 'form-control'));?>
			</div> <!-- /.col-sm-10 -->
		</div> <!-- /.form-group -->
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<?php print Form::submit('Importeren', array('class' => 'btn btn-info'));?>
			</div> <!-- /.col-sm-offset-2 /.col-sm-10 -->
		</div> <!-- /.form-group -->
		<?php print Form::close();?>
	</div> <!-- /.row -->
</div> <!-- /.container -->