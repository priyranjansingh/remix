<?php

class OriginalsongController extends Controller {

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
        $model = new Plans;
        $genre_arr = array();
        $version_arr = array();

        $genre_list = Genres::model()->findAll(array("condition"=> "parent_id = 0"));
        if (!empty($genre_list)) {
            foreach ($genre_list as $genre) {
                $genre_arr[$genre->id] = $genre->name;
            }
        }

        $version_list = Version::model()->findAll();
        if (!empty($version_list)) {
            foreach ($version_list as $version) {
                $version_arr[$version->id] = $version->name;
            }
        }


        $this->render('create', array(
            'model' => $model,'version_arr' => $version_arr, 'genre_arr' => $genre_arr
        ));
    }

    public function actionUpload() {
        $genre = "";
        $sub_genre = "";
        $version = "";
        $genre_name = "";
        
         if (isset($_REQUEST['genre'])) {
            $genre = $_REQUEST['genre'];
            $sub_genre = $_REQUEST['sub_genre'];
            $version = $_REQUEST['version'];
            $genre_detail = Genres::model()->findByPk($genre);
            if(!empty($sub_genre))
            {
                $sub_genre_detail = Genres::model()->findByPk($sub_genre);
                $folder_name = $genre_detail->folder_name . "/".$sub_genre_detail->folder_name."/";
            }
            else
            {    
                $folder_name = $genre_detail->folder_name . "/";
            }
        }
        
        
        $script_url = "admin/originalsong/upload/";
        $upload_dir = "assets/uploads/original/" . $folder_name;
        
        $data = array();
        $data['scenario'] = 'original';
        $data['genre'] = $genre;
        $data['sub_genre'] = $sub_genre;
        $data['version'] = $version;
        
        $upload_handler = new UploadHandler(null,true,null,$script_url,$upload_dir,$data);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $stripe_plan = $model->stripe_plan;
        require('./assets/stripe/init.php');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Plans'])) {
            $model->attributes = $_POST['Plans'];
            if ($model->save()) {
                // $plan_id = create_guid();
                $secret_key = getParam('stripe_secret_key');
                $free_duration = 0;
                if (!empty($model->free_duration)) {
                    $free_duration = $model->free_duration;
                }
                \Stripe\Stripe::setApiKey($secret_key);

                $p = \Stripe\Plan::retrieve($stripe_plan);
                $p->name = $model->plan_name;
                $p->amount = ($model->plan_price * 100);
                $p->interval = $model->plan_duration_type;
                $p->interval_count = $model->plan_duration;
                $p->trial_period_days = $free_duration;
                $p->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
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
        $model = new OriginalMedia('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OriginalMedia']))
            $model->attributes = $_GET['OriginalMedia'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Plans the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Plans::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Plans $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'plan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionGetSubgenre() {
        $genre_id = $_POST['genre_id'];
        $subgenre = Genres::model()->findAll(array("condition" => "parent_id = '$genre_id'"));
        ?>
        <option value="">Select Subgenre</option>
        <?php 
        if (!empty($subgenre)) {
            foreach ($subgenre as $val) {
                ?>    
                <option value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
                <?php
            }
        }
    }

}
