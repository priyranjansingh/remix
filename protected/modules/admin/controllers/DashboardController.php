<?php

class DashboardController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function actionError() {
        $this->layout = '//layouts/login_main';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionIndex() {
        if (isFrontUserLoggedIn()) {
            $active_users = Users::model()->findAll(array("condition"=>"status = 1"));
            $inactive_users = Users::model()->findAll(array("condition"=>"status = 0"));
            $paid_users = Users::model()->findAll(array("condition"=>"is_paid = 1"));
            $non_paid_users = Users::model()->findAll(array("condition"=>"is_paid = 0"));
            
            $count_active_users =   count($active_users);
            $count_inactive_users = count($inactive_users);
            $count_paid_users =     count($paid_users);
            $count_non_paid_users = count($non_paid_users);
            $this->render('index');
        } else {
            $this->redirect(CController::createUrl("/admin/login"));
        }
    }

}
