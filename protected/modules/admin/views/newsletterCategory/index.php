<?php
/* @var $this NewsletterCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Newsletter Categories',
);

$this->menu=array(
	array('label'=>'Create NewsletterCategory', 'url'=>array('create')),
	array('label'=>'Manage NewsletterCategory', 'url'=>array('admin')),
);
?>

<h1>Newsletter Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
