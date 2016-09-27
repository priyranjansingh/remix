<?php
/* @var $this NewsletterEmailController */
/* @var $model NewsletterEmail */

$this->breadcrumbs=array(
	'Newsletter Emails'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewsletterEmail', 'url'=>array('index')),
	array('label'=>'Manage NewsletterEmail', 'url'=>array('admin')),
);
?>

<h1>Create NewsletterEmail</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>