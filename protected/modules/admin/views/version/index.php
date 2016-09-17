<?php
/* @var $this GenresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Genres',
);

$this->menu=array(
	array('label'=>'Create Version', 'url'=>array('create')),
	array('label'=>'Manage Version', 'url'=>array('admin')),
);
?>

<h1>Genres</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
