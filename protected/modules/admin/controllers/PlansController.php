<?php

class PlansController extends Controller
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Plans;
               
		require('./assets/stripe/init.php');
                
		// require('./assets/stripe/lib/Stripe.php');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Plans']))
		{
			$model->attributes=$_POST['Plans'];
			if($model->validate()){
				$plan_id = create_guid();
				$secret_key = getParam('stripe_secret_key');
				$free_duration = 0;
				if(!empty($model->free_duration)){
					$free_duration = $model->free_duration;
				}
				\Stripe\Stripe::setApiKey($secret_key);

				$plan = \Stripe\Plan::create(array(
						  "amount" => ($model->plan_price * 100),
						  "interval" => $model->plan_duration_type,
						  "interval_count" => $model->plan_duration,
						  "trial_period_days" => $free_duration,
						  "name" => $model->plan_name,
						  "currency" => "usd",
						  "id" => $plan_id)
						);
				$model->stripe_plan = $plan_id;
				$model->save();
				// pre($plan,true);
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('create',array(
			'model'=>$model,
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
		$stripe_plan = $model->stripe_plan;
		require('./assets/stripe/init.php');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Plans']))
		{
			$model->attributes=$_POST['Plans'];
			if($model->save()){
				// $plan_id = create_guid();
				$secret_key = getParam('stripe_secret_key');
				$free_duration = 0;
				if(!empty($model->free_duration)){
					$free_duration = $model->free_duration;
				}
				\Stripe\Stripe::setApiKey($secret_key);

//				$p = \Stripe\Plan::retrieve($stripe_plan);
//				$p->name = $model->plan_name;
//				$p->amount = ($model->plan_price * 100);
//				$p->interval = $model->plan_duration_type;
//				$p->interval_count = $model->plan_duration;
//				$p->trial_period_days = $free_duration;
//				$p->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
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
		$model=new Plans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Plans']))
			$model->attributes=$_GET['Plans'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Plans the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Plans::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Plans $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='plan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
