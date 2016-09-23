<section class="content-header">
    <h1>
        Genres
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url() . '/admin/transactions'; ?>"><i class="fa fa-dashboard"></i> Transactions</a></li>
        <li class="active">View</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $model->invoice; ?> 
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                        <?php
                        $this->widget('zii.widgets.CDetailView', array(
                            // 'itemsCssClass' => 'table table-bordered table-hover dataTable',
                            'htmlOptions' => array("class" => "table table-bordered table-hover dataTable"),
                            'data' => $model,
                            'attributes' => array(
                                'invoice',
                                array(
                                    'type' => 'raw',
                                    'name' => 'username',
                                    'value' => $model->user_detail->username
                                ),
                                 array(
                                    'type' => 'raw',
                                    'name' => 'Plan Name',
                                    'value' => $model->plan_detail->plan_name
                                ),
                                'transaction_id',
                                'payment_method',
                                'payment_status',
                                'amount',
                                'details',
                                'date_entered'
                            ),
                        ));
                        ?>
                        <div class="col-xs-12">
                            <?php echo CHtml::link('Back', array('/admin/transactions'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>