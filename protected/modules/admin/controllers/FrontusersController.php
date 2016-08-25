<?php

class FrontusersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	protected function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
	        return false;
	    }
		if(isFrontUserLoggedIn()){
			return true;
		} else {
			$this->redirect(CController::createUrl("/admin/login"));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		// $transactions = 
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Frontusers;
		$countries = Countries::model()->findAll(array('order' => 'name ASC'));
		$countries = CHtml::listData($countries, 'id', 'name');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Frontusers']))
		{
			$model->attributes=$_POST['Frontusers'];
			$profile_pic = CUploadedFile::getInstance($model,'profile_pic');
			if($profile_pic !== null){
				$rnd = create_guid_section(8);
				$fileName = "{$rnd}-{$profile_pic}";  // random number + file name
            	$model->profile_pic = $fileName;
			} else {
				$model->profile_pic = NULL;
			}
			
			$model->role_id = getParam('front_user_role');
			$model->is_admin = 0;
			$model->password = md5($_POST['Frontusers']['password']);
			$model->verifyPassword = md5($_POST['Frontusers']['verifyPassword']);
			if($model->save()){
				if(!empty($model->profile_pic))
				$profile_pic->saveAs('assets/user-profile/'.$fileName);
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'countries'=>$countries
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$prev_profile_pic = $model->profile_pic;
		$countries = Countries::model()->findAll(array('order' => 'name ASC'));
		$countries = CHtml::listData($countries, 'id', 'name');
		$states = States::model()->findAll(array('condition' => "country_id = '$model->country_id'",'order' => 'name ASC'));
		$states = CHtml::listData($states, 'id', 'name');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Frontusers']))
		{
			if(empty($prev_profile_pic)){
				$profile_pic = CUploadedFile::getInstance($model,'profile_pic');
				if($profile_pic !== null){
					$rnd = create_guid_section(8);
					$fileName = "{$rnd}-{$profile_pic}";  // random number + file name
	            	$model->profile_pic = $fileName;
				} else {
					$model->profile_pic = NULL;
				}
			} else {
				$profile_pic = CUploadedFile::getInstance($model,'profile_pic');
				if($profile_pic !== null){
					$model->profile_pic = $prev_profile_pic;
				} else {
					$model->profile_pic = NULL;
				}
			}
			$model->attributes=$_POST['Frontusers'];
			if($model->save()){
				if(!empty($model->profile_pic))
				$profile_pic->saveAs('assets/user-profile/'.$model->profile_pic);
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'countries'=>$countries,
			'states'=>$states
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('manage'));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage()
	{
		$model=new Frontusers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Frontusers']))
			$model->attributes=$_GET['Frontusers'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionStates()
	{
		$country = $_POST['country'];
		$states = States::model()->findAll(array('condition' => "country_id = '$country'",'order' => 'name ASC'));
		echo "<option value=''>Select State</option>";
		foreach($states as $state){
			echo "<option value='".$state->id."'>".$state->name."</option>";
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Frontusers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Frontusers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Frontusers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='adminusers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
