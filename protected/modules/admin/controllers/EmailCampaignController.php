<?php

class EmailCampaignController extends Controller {

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

    public function actionIndex() {
        $model = new EmailCampaign;
        if (isset($_POST['EmailCampaign'])) {
            $model->attributes = $_POST['EmailCampaign'];
            if ($model->validate())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('email', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param version $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'version-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
