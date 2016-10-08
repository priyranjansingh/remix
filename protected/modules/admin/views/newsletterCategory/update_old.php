<?php
/* @var $this NewsletterCategoryController */
/* @var $model NewsletterCategory */

$this->breadcrumbs=array(
	'Newsletter Categories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NewsletterCategory', 'url'=>array('index')),
	array('label'=>'Create NewsletterCategory', 'url'=>array('create')),
	array('label'=>'View NewsletterCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NewsletterCategory', 'url'=>array('admin')),
);
?>

<h1>Update NewsletterCategory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>