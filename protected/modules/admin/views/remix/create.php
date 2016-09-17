<section class="content-header">
  <h1>
    Add
    <small>Remix Song</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo base_url() . '/admin/remix'; ?>"><i class="fa fa-dashboard"></i>Remix Songs</a></li>
    <li class="active">Add</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Remix Songs</h3>
				</div>
				<?php $this->renderPartial('_form', array('model'=>$model,'version_arr'=>$version_arr,'genre_arr' => $genre_arr)); ?>
			</div>
		</div>
	</div>
</section>