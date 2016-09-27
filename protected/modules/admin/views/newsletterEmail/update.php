<?php
/* @var $this NewsletterEmailController */
/* @var $model NewsletterEmail */

$this->breadcrumbs=array(
	'Newsletter Emails'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NewsletterEmail', 'url'=>array('index')),
	array('label'=>'Create NewsletterEmail', 'url'=>array('create')),
	array('label'=>'View NewsletterEmail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NewsletterEmail', 'url'=>array('admin')),
);
?>

<h1>Update NewsletterEmail <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>