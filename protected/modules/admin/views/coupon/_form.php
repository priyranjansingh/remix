<script>
    $(function() {
        $("#begin_date").datepicker(
                {
                    dateFormat: "yy-mm-dd"
                }
        );
        $("#expiry_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/jquery_ui.css">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'coupon-form',
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
            <?php echo $form->labelEx($model, 'code'); ?>
            <?php echo $form->textField($model, 'code', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'code'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'discount_type'); ?>
            <?php echo $form->dropDownList($model,'discount_type',getParam('discount_type'),array('empty'=>'Select Discount Type','class' => 'form-control')); ?>
            <?php echo $form->error($model, 'discount_type'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'discount'); ?>
            <?php echo $form->textField($model, 'discount', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'discount'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'begin_date'); ?>
            <?php echo $form->textField($model, 'begin_date', array('id' => 'begin_date', 'size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'begin_date'); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'expiry_date'); ?>
            <?php echo $form->textField($model, 'expiry_date', array('id' => 'expiry_date', 'size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'expiry_date'); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->labelEx($model, 'quantity'); ?>
            <?php echo $form->textField($model, 'quantity', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'quantity'); ?>
        </div>
    </div>


</div>
<div class="box-footer">
    <?php echo CHtml::link('Back', array('/admin/coupon'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>
<?php $this->endWidget(); ?>
