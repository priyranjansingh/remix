<?php
/* @var $this NewsletterEmailController */
/* @var $model NewsletterEmail */

$this->breadcrumbs=array(
	'Newsletter Emails'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NewsletterEmail', 'url'=>array('index')),
	array('label'=>'Create NewsletterEmail', 'url'=>array('create')),
	array('label'=>'Update NewsletterEmail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewsletterEmail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewsletterEmail', 'url'=>array('admin')),
);
?>

<h1>View NewsletterEmail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'status',
		'deleted',
		'created_by',
		'modified_by',
		'date_entered',
		'date_modified',
	),
)); ?>
