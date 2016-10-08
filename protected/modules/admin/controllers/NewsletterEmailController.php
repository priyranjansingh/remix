<?php

class NewsletterEmailController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    protected function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (isFrontUserLoggedIn()) {
            return true;
        } else {
            $this->redirect(CController::createUrl("/admin/login"));
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new NewsletterEmail;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['NewsletterEmail'])) {
            $model->attributes = $_POST['NewsletterEmail'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['NewsletterEmail'])) {
            $model->attributes = $_POST['NewsletterEmail'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->redirect(array('manage'));
    }

    /**
     * Manages all models.
     */
    public function actionManage() {
        $model = new NewsletterEmail('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NewsletterEmail']))
            $model->attributes = $_GET['NewsletterEmail'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return NewsletterEmail the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = NewsletterEmail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param NewsletterEmail $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'newsletter-email-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function getStatus($data, $row) {
        if ($data->status == 1) {
            return '<a data-id="'.$data->id.'" class="newsletter_status" href="javascript:void(0)"><span class="label label-success">Active</span></a>';
        } else if ($data->status == 0) {
            return '<a data-id="'.$data->id.'" class="newsletter_status" href="javascript:void(0)"><span class="label label-danger">Inactive</span></a>';
        }
    }
    
    
    public function getSubscribedCategories($data, $row)
    {
        return '<a href="'.Yii::app()->createUrl("admin/newsletteremail/viewcategories", array("id"=>$data->id)).'"><span class="label label-success">View</span></a>';
    }
    
    public function actionViewCategories($id)
    {
        $this->render('view_categories', array(
            'model' => $this->loadModel($id),
        ));
    }        
    
    
    public function actionchangeStatus()
    {
        $id = $_POST['id'];
        $model = NewsletterEmail::model()->findByPk($id);
        if(!empty($model))
        {
            if($model->status == 1)
            {
                $model->status = 0;
                $model->save();
                echo '<span class="label label-danger">Inactive</span>';
            } 
            else if($model->status == 0)
            {
                $model->status = 1;
                $model->save();
                echo '<span class="label label-success">Active</span>';
            }    
        }    
        
    }        

}
