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
        $users = Users::model()->findAll(array("condition" => "is_admin = 0 AND deleted = 0"));
        $model = new EmailCampaign;
        $newsletter_models = NewsletterCategory::model()->findAll(array('condition' => 'status = 1'));
        $newsletter_category = CHtml::listData($newsletter_models, 'id', 'category');
        $newsletter_category[''] = 'Select Newsletter';
        $newsletter_category = array_reverse($newsletter_category);

        if (isset($_POST['EmailCampaign'])) {
            if ($_POST['EmailCampaign']['campaign_type'] == 'normal') {
                $model->scenario = 'normal_scenario';
                if ($_POST['EmailCampaign']['user_type'] == 'custom_emails') {
                    $model->scenario = 'custom_email_scenario';
                }
            } else if ($_POST['EmailCampaign']['campaign_type'] == 'newsletter') {
                $model->scenario = 'newsletter_scenario';
            }



            $model->attributes = $_POST['EmailCampaign'];
            //pre($model->attributes,true);
            if ($model->validate()) {
                // sending emails
                if ($model->campaign_type == 'normal') {
                    if ($model->user_type == 'all') {
                        // get all the users email
                        $users = Users::model()->findAll(array("condition" => "is_admin = 0 AND deleted = 0"));
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                $subject = $model->subject;
                                $message = $model->message;
                                mailsend($user->email, $subject, $message);
                            }
                        }
                    } else if ($model->user_type == 'pending') {
                        // get all the pending users
                        $users = Users::model()->findAll(array("condition" => "is_admin = 0 AND deleted = 0 AND status = 0"));
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                $subject = $model->subject;
                                $message = $model->message;
                                mailsend($user->email, $subject, $message);
                            }
                        }
                    } else if ($model->user_type == 'active') {
                        // get all active users
                        $users = Users::model()->findAll(array("condition" => "is_admin = 0 AND deleted = 0 AND status = 1"));
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                $subject = $model->subject;
                                $message = $model->message;
                                mailsend($user->email, $subject, $message);
                            }
                        }
                    } else if ($model->user_type == 'custom_emails') {
                        $email_list = $model->email_list;
                        $email_list_arr = explode(',', $email_list);
                        if (!empty($email_list_arr)) {
                            foreach ($email_list_arr as $email) {
                                $subject = $model->subject;
                                $message = $model->message;
                                mailsend($email, $subject, $message);
                            }
                        }
                    }
                } else if ($model->campaign_type == 'newsletter') {
                    $newsletter_category = $model->newsletter_category;
                    $newsletter_mapping = NewsletterMapping::model()->findAll(array("condition"=>"newsletter_category_id = '$newsletter_category' AND status=1 AND deleted=0"));
                    // getting the emails
                    if(!empty($newsletter_mapping))
                    {
                        foreach($newsletter_mapping as $mapping)
                        {
                            $subject = $model->subject;
                            $message = $model->message;
                            mailsend($mapping->email_id->email, $subject, $message);
                        }    
                    }    
                }
                Yii::app()->user->setFlash('success', "Data saved!");
                // end of sending emails
                $this->redirect(array('index'));
            }
        }
        $this->render('email', array(
            'model' => $model,
            'newsletter_category' => $newsletter_category
        ));
    }

    public function actionChangeScenario() {
        $model = new EmailCampaign;
        $scenario = $_POST['scenario'];
        if ($scenario == 'normal_scenario') {
            $model->scenario = 'normal_scenario';
        } else if ($scenario == 'newsletter_scenario') {
            $model->scenario = 'newsletter_scenario';
        }
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
