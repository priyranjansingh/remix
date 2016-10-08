<section class="content-header">
    <h1>
        Email Campaign
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url() . '/admin/emailcampaign'; ?>"><i class="fa fa-dashboard"></i> Email Campaign</a></li>
        <li class="active">Add</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Email Campaign</h3>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'email-campaign-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                ));
                ?>
                <div class="box-body">
                    <div class="form-group">

                        <div class="col-xs-6">
                            <?php echo $form->labelEx($model, 'subject'); ?>
                            <?php echo $form->textField($model, 'subject', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'subject'); ?>
                        </div>
                        
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="form-group">
                         <div class="col-xs-6">
                            <?php echo $form->labelEx($model, 'message'); ?>
                            <?php echo $form->textField($model, 'message', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'message'); ?>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="box-footer">
                    <?php echo CHtml::link('Back', array('/admin/version'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                    <?php echo CHtml::submitButton('Send', array("class" => 'btn btn-info pull-right')); ?>
                </div>
                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</section>