<?php
/* @var $this NewsletterEmailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Newsletter Emails',
);

$this->menu=array(
	array('label'=>'Create NewsletterEmail', 'url'=>array('create')),
	array('label'=>'Manage NewsletterEmail', 'url'=>array('admin')),
);
?>

<h1>Newsletter Emails</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
