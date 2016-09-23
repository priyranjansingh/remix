<?php
/* @var $this TransactionsController */
/* @var $model Transactions */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transactions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice'); ?>
		<?php echo $form->textField($model,'invoice',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'invoice'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'plan_id'); ?>
		<?php echo $form->textField($model,'plan_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'plan_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_method'); ?>
		<?php echo $form->textField($model,'payment_method',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'payment_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_status'); ?>
		<?php echo $form->textField($model,'payment_status',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'payment_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'details'); ?>
		<?php echo $form->textArea($model,'details',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'modified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_entered'); ?>
		<?php echo $form->textField($model,'date_entered'); ?>
		<?php echo $form->error($model,'date_entered'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_modified'); ?>
		<?php echo $form->textField($model,'date_modified'); ?>
		<?php echo $form->error($model,'date_modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->