<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'plans-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>
<div class="box-body">
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'plan_name'); ?>
			<?php echo $form->textField($model,'plan_name',array('size'=>'60','maxlength'=>'128','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_name');  ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'plan_price'); ?>
			<?php echo $form->textField($model,'plan_price',array('size'=>'60','maxlength'=>'16','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_price'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<?php echo $form->labelEx($model,'plan_desc'); ?>
			<?php echo $form->textField($model,'plan_desc',array('size'=>'60','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_desc'); ?>	
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'plan_duration'); ?>
			<?php echo $form->textField($model,'plan_duration',array('maxlength'=>'3','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_duration');?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'plan_duration_type');?>
			<?php echo $form->dropDownList($model,'plan_duration_type',getParam('plan_duration'),array('empty'=>'Select Duration Type','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_duration_type'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'free_duration'); ?>
			<?php echo $form->textField($model,'free_duration',array('maxlength'=>'3','class' => 'form-control')); ?>
			<?php echo $form->error($model,'free_duration'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'free_duration_type'); ?>
			<?php echo $form->dropDownList($model,'free_duration_type',getParam('free_duration'),array('empty'=>'Select Free Duration Type','class' => 'form-control')); ?>
			<?php echo $form->error($model,'free_duration_type'); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'plan_serial'); ?>
			<?php echo $form->textField($model,'plan_serial',array('size'=>'60','maxlength'=>'128','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_serial'); ?>
		</div>
		<div class="col-xs-6">
			<?php echo $form->labelEx($model,'plan_type'); ?>
			<?php echo $form->dropDownList($model,'plan_type',getParam('plan_type'),array('empty'=>'Select Duration Type','class' => 'form-control')); ?>
			<?php echo $form->error($model,'plan_type'); ?>
		</div>
	</div>
</div>
<div class="box-footer">
    <?php echo CHtml::link('Back', array('/admin/plans'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => 'btn btn-info pull-right')); ?>
</div>
<?php $this->endWidget(); ?>