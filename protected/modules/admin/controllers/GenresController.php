<?php

class GenresController extends Controller {

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
        $model = new Genres;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $gmodels = Genres::model()->findAll(array('condition' => 'parent_id = 0'));
        $parent = CHtml::listData($gmodels, 'id', 'name');

        if (isset($_POST['Genres'])) {
            $model->attributes = $_POST['Genres'];
            if (empty($model->parent_id)) {
                $model->parent_id = 0;
            }
            $model->folder_name = clean($model->name);
            if ($model->save()) {
                if ($model->parent_id != '0') {
                    $parent_model = Genres::model()->findByPk($model->parent_id);
                    $remix_directry_path = "./assets/uploads/remix/" . $parent_model->folder_name . "/" . $model->folder_name;
                    $original_directry_path = "./assets/uploads/original/" . $parent_model->folder_name . "/" . $model->folder_name;
                } else {
                    $remix_directry_path = "./assets/uploads/remix/" . $model->folder_name;
                    $original_directry_path = "./assets/uploads/original/" . $model->folder_name;
                }
                if (!file_exists($remix_directry_path)) {
                    mkdir($remix_directry_path);
                }
                if (!file_exists($original_directry_path)) {
                    mkdir($original_directry_path);
                }


                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'parent' => $parent
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
        $gmodels = Genres::model()->findAll(array('condition' => 'parent_id = 0'));
        $parent = CHtml::listData($gmodels, 'id', 'name');
        if (isset($_POST['Genres'])) {
            $model->attributes = $_POST['Genres'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'parent' => $parent
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        // get genre detail 

        $genre_detail = Genres::model()->findByPk($id);

        if ($genre_detail->parent_id == 0) {
            // if it is parent, then delete all the subgenres of this genre
            // find all the subgenres
            $subgenres = Genres::model()->findAll(array("condition" => "parent_id = '$genre_detail->id'"));
            if (!empty($subgenres)) {
                foreach ($subgenres as $subgenre) {

                    // deleting from the mapping table 
                    $remix_medias = RemixMedia::model()->findAll(array("condition" => "sub_genre = '$subgenre->id'"));
                    $original_medias = OriginalMedia::model()->findAll(array("condition" => "sub_genre = '$subgenre->id'"));
                    if (!empty($remix_medias)) {
                        foreach ($remix_medias as $remix_media) {
                            OriginalRemix::model()->deleteAll(array("condition" => "remix_song_id = '$remix_media->id'"));
                        }
                    }
                    if (!empty($original_medias)) {
                        foreach ($original_medias as $original_media) {
                            OriginalRemix::model()->deleteAll(array("condition" => "original_song_id = '$original_media->id'"));
                        }
                    }



                    RemixMedia::model()->deleteAll(array("condition" => "sub_genre = '$subgenre->id'"));
                    OriginalMedia::model()->deleteAll(array("condition" => "sub_genre = '$subgenre->id'"));
                }
            }
            // unlinking the folder
                $remix_directry_path = "./assets/uploads/remix/" . $genre_detail->folder_name;
                $original_directry_path = "./assets/uploads/original/" . $genre_detail->folder_name;

                foreach (glob("{$remix_directry_path}/*") as $file) {
                    unlink($file);
                }
                foreach (glob("{$original_directry_path}/*") as $file) {
                    unlink($file);
                }

                rmdir($remix_directry_path);
                rmdir($original_directry_path);
            
        } else {
            // if it is child
            // getting the detail of the parent of this subgenre

            $parent_detail = Genres::model()->findByPk($genre_detail->parent_id);

            // deleting from the mapping table 
            $remix_medias = RemixMedia::model()->findAll(array("condition" => "sub_genre = '$genre_detail->id'"));
            $original_medias = OriginalMedia::model()->findAll(array("condition" => "sub_genre = '$genre_detail->id'"));
            if (!empty($remix_medias)) {
                foreach ($remix_medias as $remix_media) {
                    OriginalRemix::model()->deleteAll(array("condition" => "remix_song_id = '$remix_media->id'"));
                }
            }
            if (!empty($original_medias)) {
                foreach ($original_medias as $original_media) {
                    OriginalRemix::model()->deleteAll(array("condition" => "original_song_id = '$original_media->id'"));
                }
            }

            RemixMedia::model()->deleteAll(array("condition" => "sub_genre = '$genre_detail->id'"));
            OriginalMedia::model()->deleteAll(array("condition" => "sub_genre = '$genre_detail->id'"));
            // unlinking the folder

            $remix_directry_path = "./assets/uploads/remix/" . $parent_detail->folder_name . "/" . $genre_detail->folder_name;
            $original_directry_path = "./assets/uploads/original/" . $parent_detail->folder_name . "/" . $genre_detail->folder_name;

            foreach (glob("{$remix_directry_path}/*") as $file) {
                unlink($file);
            }
            foreach (glob("{$original_directry_path}/*") as $file) {
                unlink($file);
            }

            rmdir($remix_directry_path);
            rmdir($original_directry_path);
        }

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
        $model = new Genres('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Genres']))
            $model->attributes = $_GET['Genres'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionParents() {
        $genre_for = $_POST['genre_for'];
        $genres = Genres::model()->findAll();
        echo "<option value=''>Select Parent</option>";
        foreach ($genres as $genre) {
            echo "<option value='" . $genre->id . "'>" . $genre->name . "</option>";
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Genres the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Genres::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Genres $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'genres-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function gridParent($data) {
        if ($data->parent == 0) {
            return "No Parent";
        } else {
            return Genres::model()->findByPk($data->parent)->name;
        }
    }

    public function getParent($data, $row) {
        if ($data->parent_id !== 0) {
            $model = Genres::model()->findByPk($data->parent_id);
            if (!empty($model)) {
                return $model->name;
            }
        }
    }

}
