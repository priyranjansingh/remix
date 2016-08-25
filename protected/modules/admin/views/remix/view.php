<section class="content-header">
    <h1>
        Membership Plans
    </h1>
    <ol class="breadcrumb">
	    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	    <li><a href="<?php echo base_url() . '/admin/plans'; ?>"><i class="fa fa-dashboard"></i> Membership Plans</a></li>
	    <li class="active">View</li>
	</ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $model->plan_name; ?> 
                        <small>
                            <a href="<?php echo base_url() . '/admin/plans/update?id=' . $model->id; ?>">EDIT</a>
                        </small>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                        <?php
                        $this->widget('zii.widgets.CDetailView', array(
                            'htmlOptions' => array("class" => "table table-bordered table-hover dataTable"),
                            'data' => $model,
                            'attributes' => array(
                                'plan_name',
								'plan_desc',
								'plan_price',
								'plan_duration',
								'free_duration',
						   ),
                        ));
                        ?>
                        <div class="col-xs-12">
                            <?php echo CHtml::link('Back', array('/admin/plans'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>