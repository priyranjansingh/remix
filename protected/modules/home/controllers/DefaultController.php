<?php

class DefaultController extends Controller {

    public $layout = '//layouts/home_main';
    public $param = 'value';

    public function actionIndex() {
        $songs = Songs::model()->findAll(array("condition" => "status = '1' AND  acl=0 AND type = '1' AND is_shared = 0 AND deleted = 0", "order" => "date_entered desc", "limit" => 20));
        $videos = Videos::model()->findAll(array("condition" => "status = '1' AND  acl=0  AND type ='2' AND  is_shared = 0 AND deleted = 0", "order" => "date_entered desc", "limit" => 20));
        $this->render('index', array('songs' => $songs, 'videos' => $videos));
    }

    public function actionLoginCheck() {
        if (Yii::app()->user->isGuest) {
            echo "GUEST";
        } else {
            echo "USER";
        }
    }

    public function actionMedia($name)
    {
        $media = Media::model()->find(array("condition" => "slug = '$name'"));
        $this->render('detail',array('media' => $media));
    }

    public function actionLogin() {

        // pre($_POST['FrontUserLogin'],true);
        if (Yii::app()->user->isGuest) {
            $model = new FrontUserLogin;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['FrontUserLogin'])) {
                $model->attributes = $_POST['FrontUserLogin'];
                if ($model->validate() && $model->login()) {

                    $user_model = Users::model()->findByPk(Yii::app()->user->id);
                    Yii::app()->session['register_user_info'] = serialize($user_model);
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $this->render('index', array('model' => $model));
        } else {
            die("here");
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    public function actionSearch() {
        $srch_str = $_GET['Search']['srch_txt'];

        $songs = Songs::model()->findAll(array("condition" => "status = '1' AND type='1' AND deleted = 0 AND is_shared = 0 AND (song_name like '%$srch_str%' OR artist_name like '%$srch_str%' )   ", "order" => "date_entered desc"));
        $videos = Songs::model()->findAll(array("condition" => "status = '1' AND type='2' AND deleted = 0 AND is_shared = 0 AND (song_name like '%$srch_str%' OR artist_name like '%$srch_str%' )   ", "order" => "date_entered desc"));
        $dj = Users::model()->findAll(array("condition" => "status = '1' AND is_admin = '0'  AND deleted = 0 AND (username like '%$srch_str%' OR first_name like '%$srch_str%' OR last_name like '%$srch_str%' )   ", "order" => "date_entered desc"));
        $this->render('search_result', array('songs' => $songs, 'videos' => $videos, 'dj' => $dj));
    }

    public function actionDj($user) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $user = Users::model()->find(array("condition" => "username = '$user'"));
            $logged_in_user_id = Yii::app()->user->id;
            $recommended_list = Users::model()->getRecommendList($logged_in_user_id, "limited");

            $song_list = Songs::model()->findAll(array("condition" => "status = '1' AND acl=0 AND type='1' AND deleted = 0 AND created_by = '$user->id'    ", "order" => "date_entered desc", "limit" => 20));
            $video_list = Songs::model()->findAll(array("condition" => "status = '1' AND acl=0  AND type='2' AND deleted = 0 AND created_by = '$user->id'    ", "order" => "date_entered desc", "limit" => 20));
            $total_track_list = count($song_list) + count($video_list);
            $following_list = Followers::model()->findAll(array("condition" => "follower_id = '$user->id'"));
            $follow_unfollow = Followers::model()->find(array("condition" => " user_id = '$user->id' AND follower_id = '$logged_in_user_id' "));
            if (!empty($follow_unfollow)) {
                if ($follow_unfollow->deleted == 0) {
                    $follow_unfollow_text = "Unfollow";
                } else if ($follow_unfollow->deleted == 1) {
                    $follow_unfollow_text = "Follow";
                }
            } else {
                $follow_unfollow_text = "Follow";
            }

            $this->render('dj_profile', array(
                'user' => $user,
                'song_list' => $song_list,
                'video_list' => $video_list,
                'total_track_list' => $total_track_list,
                'following_list' => $following_list,
                'follow_unfollow_text' => $follow_unfollow_text,
                'recommended_list' => $recommended_list,
            ));
        }
    }

    public function actionSongType() {
        $user_id = $_POST['user'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $type = 1;
        } else if ($song_type == 'video') {
            $type = 2;
        }

        $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$user_id' "));

        if (!empty($shared_songs)) {
            $shared_songs_ids = array();
            foreach ($shared_songs as $s) {
                array_push($shared_songs_ids, "'$s->song_id'");
            }
            $ids = implode(',', $shared_songs_ids);
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " ((created_by = '$user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc", "limit" => 20)
            );
        } else {
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " created_by = '$user_id' ", "order" => "date_entered desc", "limit" => 20)
            );
        }



//        if ($song_type == 'audio') {
//            $song_list = Songs::model()->findAll(array("condition" => "status = '1' AND type='1' AND deleted = 0 AND created_by = '$user_id'    ", "order" => "date_entered desc", "limit" => 20));
//        } else if ($song_type == 'video') {
//            $song_list = Songs::model()->findAll(array("condition" => "status = '1' AND type='2' AND deleted = 0 AND created_by = '$user_id'    ", "order" => "date_entered desc", "limit" => 20));
//        }

        $this->renderPartial('ajax_song', array('song_list' => $song_list));
    }

    public function actionHomeSongType() {
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $song_list = Songs::model()->findAll(array("condition" => "status = '1' AND type='1' AND deleted = 0  ", "order" => "date_entered desc", "limit" => 20));
        } else if ($song_type == 'video') {
            $song_list = Songs::model()->findAll(array("condition" => "status = '1' AND type='2' AND deleted = 0  ", "order" => "date_entered desc", "limit" => 20));
        }
        $this->renderPartial('home_ajax_song', array('song_list' => $song_list));
    }

    public function actionAjaxTrending() {
        $user = $_POST['user'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $trending_song = Downloads::model()->trendingSong($user);
            $this->renderPartial('ajax_song', array('song_list' => $trending_song));
        } else if ($song_type == 'video') {
            $trending_video = Downloads::model()->trendingVideo($user);
            $this->renderPartial('ajax_song', array('song_list' => $trending_video));
        }
    }

    public function actionHomeAjaxTrending() {
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $trending_AjaxPlaylistsong = Downloads::model()->HomeTrendingSong();
            $this->renderPartial('home_ajax_song', array('song_list' => $trending_song));
        } else if ($song_type == 'video') {
            $trending_video = Downloads::model()->HomeTrendingVideo();
            $this->renderPartial('home_ajax_song', array('song_list' => $trending_video));
        }
    }

    public function actionAjaxJustAdded() {
        $user = $_POST['user'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $song = Users::model()->AjaxJustAdded($user, 1);
            $this->renderPartial('ajax_song', array('song_list' => $song));
        } else if ($song_type == 'video') {
            $video = Users::model()->AjaxJustAdded($user, 2);
            $this->renderPartial('ajax_song', array('song_list' => $video));
        }
    }

    public function actionHomeAjaxJustAdded() {
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $song = Users::model()->HomeAjaxJustAdded(1);
            $this->renderPartial('home_ajax_song', array('song_list' => $song));
        } else if ($song_type == 'video') {
            $video = Users::model()->HomeAjaxJustAdded(2);
            $this->renderPartial('home_ajax_song', array('song_list' => $video));
        }
    }

    public function actionHomeGenre() {
        $song_type = $_POST['song_type'];
        $genre = $_POST['genre'];
        if ($song_type == 'audio') {
            $song = Users::model()->HomeGenre(1, $genre);
            $this->renderPartial('home_ajax_song', array('song_list' => $song));
        } else if ($song_type == 'video') {
            $video = Users::model()->HomeGenre(2, $genre);
            $this->renderPartial('home_ajax_song', array('song_list' => $video));
        }
    }

    public function actionVerifysong() {
        $song = $_POST['song'];
        $media = Media::model()->find(array('condition' => "slug = '$song'"));
        if ($media === null) {
            $array['error'] = true;
        } else {
            Yii::app()->s3->setAuth(Yii::app()->params['access_key_id'], Yii::app()->params['secret_access_key']);
            $url = Yii::app()->s3->getAuthenticatedURL($media->s3_bucket, $media->file_name, 600, false, false);
            $array['error'] = false;
            $array['song_name'] = $media->song_name;
            $array['artist_name'] = $media->artist_name;
            $array['album_art'] = $media->album_art;
            $array['url'] = $url;
        }

        echo json_encode($array, true);
    }

    public function actionAjaxMyDrive() {
        $user = $_POST['user'];
        $song_type = $_POST['song_type'];


        if ($song_type == 'audio') {
            $type = 1;
        } else if ($song_type == 'video') {
            $type = 2;
        }


        $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$user' "));

        if (!empty($shared_songs)) {
            $shared_songs_ids = array();
            foreach ($shared_songs as $s) {
                array_push($shared_songs_ids, "'$s->song_id'");
            }
            $ids = implode(',', $shared_songs_ids);
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " ((created_by = '$user' AND acl=0) OR (id IN($ids)) )  ", "order" => "date_entered desc", "limit" => 20)
            );
        } else {
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND acl=0 AND type='$type' AND deleted = 0 AND"
                        . " created_by = '$user' ", "order" => "date_entered desc", "limit" => 20)
            );
        }

        $this->renderPartial('ajax_song', array('song_list' => $song_list));
    }

    public function actionAjaxPlaylist() {
        $user = $_POST['user'];
        $playlists = Playlists::model()->findAll(array("condition" => "status = '1'  AND deleted = 0 AND user_id = '$user'    ", "order" => "date_entered desc", "limit" => 20));
        $this->renderPartial('ajax_playlist', array('playlists' => $playlists));
    }

    public function actionHomeAjaxPlaylist() {
        $playlists = Playlists::model()->findAll(array("condition" => "status = '1'  AND deleted = 0 ", "order" => "date_entered desc", "limit" => 20));
        $this->renderPartial('home_ajax_playlist', array('playlists' => $playlists));
    }

    public function actionAjaxPlaylistSongs() {
        $playlist = $_POST['playlist'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $type = 1;
        } else if ($song_type == 'video') {
            $type = 2;
        }
        $playlist_detail = Playlists::model()->findByPk($playlist);
        $playlist_songs = PlaylistSongs::model()->findAll(array("condition" => "playlist_id = '$playlist' AND type='$type' "));
        $this->renderPartial('ajax_playlist_songs', array('playlist_songs' => $playlist_songs, 'playlist' => $playlist, 'playlist_name' => $playlist_detail->name));
    }

    public function actionHomeAjaxPlaylistSongs() {
        $playlist = $_POST['playlist'];
        $playlist_detail = Playlists::model()->findByPk($playlist);
        $playlist_songs = PlaylistSongs::model()->findAll(array("condition" => "playlist_id = '$playlist'"));
        $this->renderPartial('home_ajax_playlist_songs', array('playlist_songs' => $playlist_songs, 'playlist_name' => $playlist_detail->name));
    }

    public function actionFollowUnfollow() {
        if (Yii::app()->user->id) {
            $return_arr = array();
            $user_id = $_POST['dj_id'];
            $follower_id = $_POST['user_id'];
            $follow_unfollow = Followers::model()->find(array("condition" => " user_id = '$user_id' AND follower_id = '$follower_id' "));
            if (empty($follow_unfollow)) {
                $follower_model = new Followers;
                $follower_model->user_id = $user_id;
                $follower_model->follower_id = $follower_id;
                $follower_model->created_by = $follower_id;
                $follower_model->save();
                $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                $dj_followers_count = count($user->followers_list);
                $return_arr['followers_count'] = $dj_followers_count;
                $return_arr['follow_unfollow_text'] = "Unfollow";
                echo json_encode($return_arr);
            } else {
                if ($follow_unfollow->deleted == 0) {
                    $follow_unfollow->deleted = 1;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                    $return_arr['followers_count'] = $dj_followers_count;
                    $return_arr['follow_unfollow_text'] = "Follow";
                    echo json_encode($return_arr);
                } else if ($follow_unfollow->deleted == 1) {
                    $follow_unfollow->deleted = 0;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                    $return_arr['followers_count'] = $dj_followers_count;
                    $return_arr['follow_unfollow_text'] = "Unfollow";
                    echo json_encode($return_arr);
                }
            }
        }
    }

    public function actionFollowUnfollowRecommend() {
        if (Yii::app()->user->id) {
            $return_arr = array();
            $user_id = $_POST['dj_id'];
            $follower_id = $_POST['user_id'];
            $follow_unfollow = Followers::model()->find(array("condition" => " user_id = '$user_id' AND follower_id = '$follower_id' "));
            if (empty($follow_unfollow)) {
                $follower_model = new Followers;
                $follower_model->user_id = $user_id;
                $follower_model->follower_id = $follower_id;
                $follower_model->created_by = $follower_id;
                $follower_model->save();
                $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                $dj_followers_count = count($user->followers_list);
            } else {
                if ($follow_unfollow->deleted == 0) {
                    $follow_unfollow->deleted = 1;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                } else if ($follow_unfollow->deleted == 1) {
                    $follow_unfollow->deleted = 0;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                }
            }
            $logged_in_user_id = Yii::app()->user->id;
            $recommended_list = Users::model()->getRecommendList($logged_in_user_id, "limited");
            $this->renderPartial('ajax_recommended', array('recommended_list' => $recommended_list));
        }
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->baseUrl . '/home');
    }

    public function actionSignup() {
        if (Yii::app()->user->isGuest) {
            $model = new Registration;
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'signup-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['Registration'])) {
                $model->attributes = $_POST['Registration'];
                $model->role_id = getParam('front_user_role');
                if ($model->validate()) {
                    $model->password = md5($model->password);
                    $model->confirm_password = $model->password;
                    $model->save();
                    Yii::app()->session['register_user_info'] = serialize($model);
                    
                    // creating of the bucket
                    $aws = new AS3;
                    $bucket = $model->username . '-' . create_guid_section(6);
                    $aws->addBucket($bucket);
                    $user_model = Users::model()->findByPk($model->id);
                    $user_model->s3_bucket = $bucket;
                    $user_model->save();


                    // process of autologin of the user
                    $login_model = new AutoLogin;
                    $login_model->username = $model->username;
                    $login_model->password = $model->password;
                    if ($login_model->validate() && $login_model->login()) {
                        // making entry in the user_plan table
                        $user_plan = Plans::model()->find(array("condition" => "plan_type = 'basic'"));
                        $user_plan_model = new UserPlan;
                        $user_plan_model->plan_id = $user_plan->id;
                        $user_plan_model->user_id = $model->id;
                        $user_plan_model->plan_start_date = date("Y-m-d");
                        $user_plan_model->plan_end_date = date("Y-m-d", strtotime("+ 20 years"));
                        $user_plan_model->save();
                        // end of making entry in the user_plan table

                        $this->redirect(base_url() . '/home/chooseplans');
                    } else {
                        pre($model->getErrors(), true);
                    }

                    //  end of process of of autologin of the user 
                } else {
                    pre($model->getErrors());
                }
            }
            // $this->render('register', array('model' => $model));
        } else {
            $this->redirect(array("myaccount"));
        }
    }

    public function actionChooseplans() {
        $this->layout = '//layouts/payment_main';
        $user = Yii::app()->session['register_user_info'];
        $user = unserialize($user);
        $user_plan = UserPlan::model()->getUserActivePlan($user->id);
        $plans = BaseModel::getAll('Plans', array('order' => 'plan_serial ASC'));
        $this->render('plans', array('plans' => $plans, 'user_plan' => $user_plan));
    }

    // function to hit when user select a plan , this is hit before opening the pop up
    public function actionAjaxPlanDetail() {
        $plans = BaseModel::getAll('Plans', array('order' => 'plan_serial ASC'));
        $plan = $_POST['plan'];
        $plan = Plans::model()->findByPk($plan);
        Yii::app()->session['register_user_plan'] = serialize($plan);
        $user = Yii::app()->session['register_user_info'];
        $user = unserialize($user);
        $this->renderPartial('ajax_plan_detail', array('plans' => $plans, 'plan' => $plan, 'user' => $user));
    }

    public function actionPayment($plan) {
        $this->layout = '//layouts/payment_main';
        $plan = Plans::model()->findByPk($plan);
        if ($plan === null) {
            $this->redirect(array('chooseplans'));
        } else {
            Yii::app()->session['register_user_plan'] = serialize($plan);
            $user = Yii::app()->session['register_user_info'];
            $user = unserialize($user);
            $this->render("payment", array('plan' => $plan, 'user' => $user));
        }
    }

    public function actionProcess() {
        if (isset($_POST['stripeToken'])) {
            require('./assets/stripe/init.php');
            $token = $_POST['stripeToken'];
            $plan = Yii::app()->session['register_user_plan'];
            $plan = unserialize($plan);
            //pre($plan,true);
            $user = Yii::app()->session['register_user_info'];
            $user = unserialize($user);
            $secret_key = getParam('stripe_secret_key');
            \Stripe\Stripe::setApiKey($secret_key);
            $customer = \Stripe\Customer::create(array(
                        "source" => $token,
                        "plan" => $plan->stripe_plan,
                        "email" => $user->email,
                        "id" => $user->id)
            );
            $customer = json_decode(substr($customer, 22));
            $invoice = Invoice::model()->findByPk(getParam('invoice'));
            $inv_no = $invoice->invoice_text . '-' . $invoice->invoice_count;
            $transaction = new Transactions;
            $transaction->invoice = $inv_no;
            $transaction->user_id = $customer->id;
            $transaction->plan_id = $customer->subscriptions->data[0]->plan->id;
            $transaction->transaction_id = $customer->subscriptions->data[0]->id;
            $transaction->payment_method = 'stripe';
            $transaction->amount = ($customer->subscriptions->data[0]->plan->amount / 100);
            $transaction->details = json_encode($customer);
            $transaction->payment_status = 'pending';
            if ($transaction->save()) {
                $invoice->invoice_count = str_pad(($invoice->invoice_count + 1), 6, '0', STR_PAD_LEFT);
                $invoice->save();

                $u = Users::model()->findByPk($user->id);
                $u->is_paid = 1;
                $u->save();
            }


            // createS3bucket($user->username);
            $aws = new AS3;
            $bucket = $user->username . '-' . create_guid_section(6);
            $aws->addBucket($bucket);
            $user_model = Users::model()->findByPk($user->id);
            $user_model->s3_bucket = $bucket;
            $user_model->save();
            $user_plan = new UserPlan;
            $user_plan->plan_id = $plan->id;
            $user_plan->user_id = $user->id;
            $user_plan->plan_start_date = date("Y-m-d");
            $user_plan->plan_end_date = date("Y-m-d", strtotime('+' . $plan->plan_duration . ' ' . $plan->plan_duration_type . 's'));
            $user_plan->save();
            Yii::app()->session['payment_success'] = true;
            $this->redirect(array('success'));
            // pre($customer,true);
        }
    }

    public function actionTest() {
        // $info = new FileInfo("assets/temp/Kehlani - 24 7 (Dirty).mp3");
        // $url = "http://neeraj-f0b1ea.s3.amazonaws.com/Mark%20J%20-%20Marvelous%20Light%20%282%29%20%281%29.mp3?AWSAccessKeyId=AKIAJBTQKEKGZSJDLKSA&Expires=1463945001&Signature=VF0m%2FOeusUb0ZDe2HjcAxp0i4VA%3D";
        // $info = getSongBPM($url);
        // pre($info,true);
        $url = "http://neeraj-f0b1ea.s3.amazonaws.com/Mark%20J%20-%20Marvelous%20Light%20%282%29%20%281%29.mp3?AWSAccessKeyId=AKIAJBTQKEKGZSJDLKSA&Expires=1463945001&Signature=VF0m%2FOeusUb0ZDe2HjcAxp0i4VA%3D";
        $info = getSongBPM($url);
        pre($info, true);
        // getSongBPM($url);
        // $api = new ApiSearch($info->data['artist'], $info->data['song'], $info->data['album']);
        // pre($api);
        // $model = Media::model()->findAll();
        // pre($model,true);
        require('./assets/stripe/init.php');

        $secret_key = getParam('stripe_secret_key');

        \Stripe\Stripe::setApiKey($secret_key);
        $tests = Test::model()->findAll();
        // $test = Test::model()->findByPk('1f4b7eb2-4341-d34b-e0f1-574611ee2536');
        // foreach($tests as $test){
        //     pre($test->response);
        // }
        // die;
        foreach ($tests as $test) {
            // $test = Test::model()->findByPk('173556cc-98bd-9d4f-ef5e-5740c531171a');
            foreach ($tests as $test) {
                // pre($test->response,true);
                // Stripe\Event JSON: 
                // $a = substr($test->response, 19);
                // pre($a, true);
                // $find = substr($test->response, 0, 19);
                // if($find === "Stripe\Event JSON: "){
                $event_json = json_decode($test->response);
                $find = substr($test->response, 0, 19);
                if ($find === "Stripe\Event JSON: ") {
                    $event_json = json_decode(substr($test->response, 19));

                    $event = \Stripe\Event::retrieve($event_json->id);
                    $event = substr($event, 19);
                    $event_json = json_decode($event);
                    // $data = $event->data->object;
                    // $invoice = $data->lines->data[0];
                    // pre($event_json);
                    // pre($event);

                    if (isset($event_json->id)) {

                        try {
                            // to verify this is a real event, we re-retrieve the event from Stripe 
                            $event = \Stripe\Event::retrieve($event_json->id);
                            // $model = new Test;
                            // $model->response = $event;
                            // $model->save();
                            // pre($event);
                            $event = substr($event, 19);
                            $event = json_decode($event);
                            // pre($event,true);
                            $data = $event->data->object;
                            // successful payment
                            if ($event->type == 'invoice.payment_succeeded') {
                                $invoice = $data->lines->data[0];
                                // send a payment receipt email here
                                // retrieve the payer's information
                                $customer = \Stripe\Customer::retrieve($data->customer);
                                // pre($customer);
                                // echo "--------------------------------------------------";
                                $customer = json_decode(substr($customer, 22));
                                // pre($customer,true);
                                $email = $customer->email;

                                $amount = $invoice->amount / 100; // amount comes in as amount in cents, so we need to convert to dollars

                                $t_model = Transactions::model()->find(array("condition" => "transaction_id = '" . $invoice->id . "'"));
                                if ($t_model !== null) {
                                    $t_model->payment_status = "paid";
                                    $t_model->save();
                                }

                                $subject = 'Jock Drive Payment Receipt';
                                $headers = 'From: <info@dealrush.in>';
                                $message = "Hello User,\n\n";
                                $message .= "You have successfully made a payment of $" . $amount . "\n";
                                $message .= "Thank you.";
                                echo $message;
                                mail($email, $subject, $message, $headers);
                            } else {
                                echo $event->type;
                            }
                        } catch (Exception $e) {
                            $headers = 'From: <info@dealrush.in>';
                            mail('neeraj24a@gmail.com', 'Jockdrive Payment Exception', $e, $headers);
                        }
                    }
                    // }

                    pre($event);
                }

                // this will be used to retrieve the event from Stripe
                // $event_id = $event_json->id;
                // pre($event_id, true);
                // if (isset($event_json->id)) {
            }
            // }
            // }
        }
        $s3 = new AS3;
        $result = $s3->getSong("priyranjan-e15319", "Mark J - Marvelous Light.mp3");
        pre($result);
    }

    public function actionWebhook($listner) {

        if (isset($listner) && $listner == 'stripe') {

            global $stripe_options;

            require('./assets/stripe/init.php');

            $secret_key = getParam('stripe_secret_key');

            \Stripe\Stripe::setApiKey($secret_key);

            // retrieve the request's body and parse it as JSON
            $body = @file_get_contents('php://input');
            $model = new Test;
            $model->response = $body;
            $model->save();
            // grab the event information
            $event_json = json_decode($body);

            // this will be used to retrieve the event from Stripe
            $event_id = $event_json->id;
            // pre($event_id, true);
            if (isset($event_json->id)) {

                try {
                    // to verify this is a real event, we re-retrieve the event from Stripe 
                    $event = \Stripe\Event::retrieve($event_json->id);
                    // $model = new Test;
                    // $model->response = $event;
                    // $model->save();
                    // pre($event);
                    $event = substr($event, 19);
                    $event = json_decode($event);
                    // pre($event,true);
                    $data = $event->data->object;
                    // successful payment
                    if ($event->type == 'invoice.payment_succeeded') {
                        $invoice = $data->lines->data[0];
                        // send a payment receipt email here
                        // retrieve the payer's information
                        $customer = \Stripe\Customer::retrieve($data->customer);
                        // pre($customer);
                        // echo "--------------------------------------------------";
                        $customer = json_decode(substr($customer, 22));
                        // pre($customer,true);
                        $email = $customer->email;

                        $amount = $invoice->amount / 100; // amount comes in as amount in cents, so we need to convert to dollars
                        $transaction_id = $invoice->id;
                        $t_model = Transactions::model()->find(array("condition" => "transaction_id = '$transaction_id'"));
                        $user_id = $t_model->user_id;
                        $t = "No Transaction Hit";
                        if ($t_model !== null) {
                            $t_model->payment_status = "paid";
                            if ($t_model->save()) {
                                $t = $t_model->id;
                            } else {
                                $t = serialize($t_model->getErrors());
                            }
                        }

                        $u_plan = UserPlan::model()->find(array("condition" => "user_id = '$user_id'"));
                        $u_plan->plan_end_date = date("Y-m-d", $invoice->period->end);
                        if ($u_plan->save()) {
                            $u = $u_plan->id;
                        } else {
                            $u = serialize($u_plan->getErrors());
                        }
                        $subject = 'Jock Drive Payment Receipt';
                        $headers = 'From: <info@dealrush.in>';
                        $message = "Hello $email,\n\n";
                        $message .= "You have successfully made a payment of $" . $amount . "\n";
                        $message .= "User Plan : " . $u . "\n";
                        $message .= "Transaction : " . $t . "\n";
                        $message .= "Thank you.";
                        // echo $message;
                        mail('neeraj24a@gmail.com', $subject, $message, $headers);
                    } else {
                        echo $event->type;
                    }
                } catch (Exception $e) {
                    $headers = 'From: <info@dealrush.in>';
                    mail('neeraj24a@gmail.com', 'Jockdrive Payment Exception', $e, $headers);
                }
            }
        }
    }

    public function actionSuccess() {
        if (isset(Yii::app()->session['payment_success'])) {
            $user = Yii::app()->session['register_user_info'];
            $user = unserialize($user);

            $model = new AutoLogin;
            // pre($user->username);
            // pre($user->password);
            // new AutoIdentity($user->username,$user->password);
            $model->username = $user->username;
            $model->password = $user->password;
            if ($model->validate() && $model->login()) {
                $this->redirect(array('purchased'));
            } else {
                pre($model->getErrors(), true);
            }
            $this->redirect(array('purchased'));
        }
    }

    public function actionPurchased() {
        if (isset(Yii::app()->session['payment_success'])) {
            $plan = Yii::app()->session['register_user_plan'];
            $plan = unserialize($plan);
            $this->render('success', array('plan' => $plan));
        }
    }

    public function actionUpload() {
        $mode = 'authenticated-read';
        if (isset($_REQUEST['mode'])) {
            $mode = $_REQUEST['mode'];
        }
        $user_id = Yii::app()->user->id;
        $bucket = Users::model()->findByPk($user_id)->s3_bucket;
        $upload_handler = new UploadHandlerS3(null, true, null, $bucket, $mode);
        // pre($upload_handler,true);
    }

    public function actionAddsongs() {
        $temp = Temp::model()->findAll();

        if ($temp !== null) {
            Yii::app()->s3->setAuth(Yii::app()->params['access_key_id'], Yii::app()->params['secret_access_key']);
            foreach ($temp as $t) {
                $file_url = Yii::app()->s3->getAuthenticatedURL($t->s3_bucket, $t->file_name, 3600, false, false);
                //pre($file_url,true);
                if (copy($file_url, "assets/temp/" . $t->file_name)) {
                    $info = new FileInfo("assets/temp/" . $t->file_name);

                    if ($info->data['error'] === false) {
                        $g = $info->data['genre'];
                        $api = new ApiSearch($info->data['artist'], $info->data['song'], $info->data['album']);
                        if ($g == "NA") {
                            $g = $api->genre;
                        }

                        $genre = Genres::model()->find(array("condition" => "name = '$g'"));
                        if ($genre === null) {
                            $g_model = new Genres;
                            $g_model->name = $g;
                            $g_model->parent = null;
                            if ($g_model->save()) {
                                $g = $g_model->id;
                            } else {
                                pre($g_model->getErrors(), true);
                            }
                        } else {
                            $g = $genre->id;
                        }

                        $bpm = getSongBPM($file_url);
                        $key = getSongKey($file_url);

                        // $bpm = 'BPM';
                        // $key = 'key';
                        $model = new Media;
                        //pre($model,true);
                        $model->id = create_guid();
                        $model->type = $t->type;
                        $model->song_name = $info->data['song'];
                        $model->artist_name = $info->data['artist'];
                        $model->acl = $t->acl;
                        $model->genre = $g;
                        $model->s3_url = $t->s3_url;
                        $model->s3_bucket = $t->s3_bucket;
                        $model->file_name = $t->file_name;
                        $model->album_art = $api->album_art;
                        $model->bpm = $bpm;
                        $model->song_key = $key;
                        $model->created_by = $t->user_id;
                        $model->modified_by = $t->user_id;
                        $model->status = 1;
                        $model->deleted = 0;
                        $model->date_entered = date("Y-m-d H:i:s");
                        $model->date_modified = date("Y-m-d H:i:s");
                        if ($model->save()) {
                            unlink("assets/temp/" . $t->file_name);
                            Temp::model()->deleteByPk($t->id);
                        } else {
                            pre($api->bpm);
                            pre($model->getErrors(), true);
                        }
                    } else {
                        unlink("assets/temp/" . $t->file_name);
                        Temp::model()->deleteByPk($t->id);
                    }
                }
            }
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Genres $model the model to be validated
     */
    protected function performAjaxValidation($model, $form_id) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form_id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionWidgetUpload() {
        $user_id = $_POST['user_id'];
        $song_id = $_POST['song_id'];

        $result_arr = array();
        $song_detail = Songs::model()->findByPk($song_id);

        if (!empty($song_detail)) {
            if ($song_detail->created_by == $user_id) {
                $result_arr['status'] = 'failure';
                $result_arr['message'] = 'You can not share this song';
            } else {
                $model_chk = SongShare::model()->find(array("condition" => "user_id ='$user_id' AND song_id='$song_id'"));

                if (!empty($model_chk)) {
                    $result_arr['status'] = 'failure';
                    $result_arr['message'] = 'You have already shared this song';
                } else {
                    $model = new SongShare;
                    $model->user_id = $user_id;
                    $model->song_id = $song_id;
                    $model->type = $song_detail->type;
                    $model->save();
                    $result_arr['status'] = 'success';
                    $result_arr['message'] = 'You have successfully added the song';
                }
            }
        }
        echo json_encode($result_arr);
    }

    public function actionWidgetLike() {
        if (Yii::app()->user->id) {
            $user_id = $_POST['user_id'];
            $song_id = $_POST['song_id'];
            $song_like = SongLike::model()->find(array("condition" => " user_id = '$user_id' AND song_id = '$song_id' "));
            if (empty($song_like)) {
                $song_like_model = new SongLike;
                $song_like_model->user_id = $user_id;
                $song_like_model->song_id = $song_id;
                $song_like_model->save();
                $song = Songs::model()->find(array("condition" => "id = '$song_id'"));
                $song_like_count = count($song->like_details);
            } else {
                if ($song_like->deleted == 0) {
                    $song_like->deleted = 1;
                    $song_like->save();
                    $song = Songs::model()->find(array("condition" => "id = '$song_id'"));
                    $song_like_count = count($song->like_details);
                } else if ($song_like->deleted == 1) {
                    $song_like->deleted = 0;
                    $song_like->save();
                    $song = Songs::model()->find(array("condition" => "id = '$song_id'"));
                    $song_like_count = count($song->like_details);
                }
            }
            echo $song_like_count;
        }
    }

    public function actionWidgetDownload($file) {

        $song_detail = Songs::model()->findByPk($file);

        $s3 = new AS3;
        $result = $s3->getSong($song_detail->s3_bucket, $song_detail->file_name);

        // try {
        // Display the object in the browser
        header("Content-Type: {$result['ContentType']}");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"$song_detail->file_name\"");
        // header('Content-Disposition: attachment; filename='.$song_detail->file_name);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $user_id = Yii::app()->user->id;
        $download_model = new Downloads;
        $download_model->user_id = $user_id;
        $download_model->song_id = $song_detail->id;
        $download_model->owner_id = $song_detail->created_by;
        $download_model->type = $song_detail->type;
        $download_model->save();
        ob_clean();
        flush();
        echo $result['Body'];
    }

    public function actionWidgetAddToPlaylist() {
        $song_id = $_POST['song_id'];
        $user_id = Yii::app()->user->id;
        $playlist = Playlists::model()->findAll(array("condition" => "user_id = '$user_id'"));
        $playlist_model = new Playlists;
        $this->renderPartial('ajax_add_playlist', array('playlist' => $playlist, 'song_id' => $song_id, 'playlist_model' => $playlist_model));
    }

    public function actionAjaxAddToPlaylist() {
        $song = $_POST['song'];
        $playlist = $_POST['playlist'];
        $song_detail = Songs::model()->findByPk($song);
        $playlist_model = PlaylistSongs::model()->find(array("condition" => "playlist_id = '$playlist' AND song_id ='$song' AND deleted = 0 "));
        if (empty($playlist_model)) {
            $playlist_new_model = new PlaylistSongs;
            $playlist_new_model->playlist_id = $playlist;
            $playlist_new_model->song_id = $song;
            $playlist_new_model->type = $song_detail->type;
            $playlist_new_model->validate();
            $playlist_new_model->save();
        }
    }

    public function actionAjaxAddPlaylistWithSong() {
        $model = new Playlists;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'playlist-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['Playlists'])) {
            $model->attributes = $_POST['Playlists'];
            $model->user_id = Yii::app()->user->id;
            if ($model->validate()) {
                $model->save();
                // adding to playlist_songs table

                $song_detail = Songs::model()->findByPk($_POST['playlist_song']);

                $playlist_songs = new PlaylistSongs;
                $playlist_songs->playlist_id = $model->id;
                $playlist_songs->song_id = $_POST['playlist_song'];
                $playlist_songs->type = $song_detail->type;
                $playlist_songs->save();


                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }
    }

    // it is hit whenn the payment button is clicked

    public function actionSaveTransaction() {
        $plan = Yii::app()->session['register_user_plan'];
        $plan = unserialize($plan);
        $user = Yii::app()->session['register_user_info'];
        $user = unserialize($user);

        $invoice = Invoice::model()->findByPk(getParam('invoice'));
        $inv_no = $invoice->invoice_text . '-' . $invoice->invoice_count;
        $transaction = new Transactions;
        $transaction->invoice = $inv_no;
        $transaction->user_id = $user->id;
        $transaction->plan_id = $plan->id;
        $transaction->payment_method = 'paypal';
        $transaction->amount = $plan->plan_price;
        $transaction->payment_status = 'pending';
        if ($transaction->save()) {
            $invoice->invoice_count = str_pad(($invoice->invoice_count + 1), 6, '0', STR_PAD_LEFT);
            $invoice->save();
        }
    }

    public function actionApplyCouponCode() {
        $code = $_POST['code'];
        $plan = Yii::app()->session['register_user_plan'];
        $plan = unserialize($plan);
        $plan_price = $plan->plan_price;
        $result_array = array();
        if (!empty($code)) {
            $cur_date = date("Y-m-d");
            $coupon = Coupon::model()->find(array("condition" => "code = '$code' AND  status=1 AND deleted = 0 AND expiry_date >= '$cur_date' AND begin_date <= '$cur_date' "));
            if (!empty($coupon)) {
                $discount = $coupon->discount;
                $discount_type = $coupon->discount_type;
                if ($discount_type == 'number') {
                    $final_payable_amount = $plan_price - $discount;
                } else if ($discount_type == 'percent') {
                    $final_payable_amount = $plan_price - ($plan_price * $discount / 100);
                }
                $result_array['status'] = 'success';
                $result_array['message'] = 'Your final amount payable is ' . $final_payable_amount;
                $result_array['amount'] = $final_payable_amount;
            } else {
                $result_array['status'] = 'failure';
                $result_array['message'] = 'Sorry there is no coupon by this code';
            }
        } else {
            $result_array['status'] = 'failure';
            $result_array['message'] = 'Couponcode can not be blank';
        }
        echo json_encode($result_array);
    }

    public function actionNotify() {

        if ($_POST) {
            // saving in log file
            $fp = fopen('./assets/payment_log.txt', 'w');
            fwrite($fp, json_encode($_POST));
            fclose($fp);
            // end of saving in the log file 
            if (!empty($_POST['payment_status'])) {
                if ($_POST['payment_status'] == "Completed") {

                    $custom = $_POST['custom'];
                    $custom_arr = explode("#", $custom);
                    $user_id = $custom_arr[0];
                    $plan_id = $custom_arr[1];
                    $transaction = Transactions::model()->find(array("condition" => "user_id = '$user_id' AND plan_id = '$plan_id' AND payment_status = 'pending'"));
                    if (!empty($transaction)) {
                        $transaction->payment_status = 'paid';
                        $transaction->transaction_id = $_POST['txn_id'];
                        $transaction->details = json_encode($_POST);
                        $transaction->date_modified = date("Y-m-d H:i:s", strtotime($_POST['payment_date']));
                        $transaction->save();
                    }

                    // making entry in the user_plan table 
                    // first check whether there is any record or not by that user_id and plan_id and if there is any record then update 
                    // that otherwise make fresh entry 
                    // Before doing this if there is any entry of this user in the user_plan table of another plan id just delete that
                    $old_user_plan = UserPlan::model()->find(array("condition" => "user_id = '$user_id' AND plan_id != '$plan_id' AND status = 1 AND deleted = 0 "));
                    if (!empty($old_user_plan)) {
                        $old_user_plan->status = 0;
                        $old_user_plan->deleted = 1;
                        $old_user_plan->save();
                    }




                    $user_plan = UserPlan::model()->find(array("condition" => "user_id = '$user_id' AND plan_id = '$plan_id' AND status = 1 AND deleted = 0 "));
                    if (empty($user_plan)) {
                        $user_plan_model = new UserPlan;
                        $user_plan_model->user_id = $user_id;
                        $user_plan_model->plan_id = $plan_id;
                        // getting plan detail
                        $plan_model = Plans::model()->findByPk($plan_id);

                        $user_plan_model->plan_start_date = date("Y-m-d");
                        $nxt_date_string = "+ " . $plan_model->plan_duration . " " . $plan_model->plan_duration_type;
                        $user_plan_model->plan_end_date = date("Y-m-d", strtotime($nxt_date_string));
                        $user_plan_model->save();
                    } else {
                        // only update the current  record
                        // getting plan detail
                        $plan_model = Plans::model()->findByPk($plan_id);
                        $nxt_date_string = "+ " . $plan_model->plan_duration . " " . $plan_model->plan_duration_type;
                        $user_plan_model->plan_end_date = date("Y-m-d", strtotime($nxt_date_string));
                        $user_plan_model->save();
                    }

                    // making entry of fresh row in the transaction table i.e. invoice

                    $invoice = Invoice::model()->findByPk(getParam('invoice'));
                    $inv_no = $invoice->invoice_text . '-' . $invoice->invoice_count;
                    $transaction = new Transactions;
                    $transaction->invoice = $inv_no;
                    $transaction->user_id = $user_id;
                    $transaction->plan_id = $plan_id;
                    $transaction->payment_method = 'paypal';
                    $transaction->amount = $plan_model->plan_price;
                    $transaction->payment_status = 'pending';
                    if ($transaction->save()) {
                        $invoice->invoice_count = str_pad(($invoice->invoice_count + 1), 6, '0', STR_PAD_LEFT);
                        $invoice->save();
                    }

                    // end of making entry of fresh row in the transaction table i.e. invoice


                    $u = Users::model()->findByPk($user_id);
                    $u->is_paid = 1;
                    $u->save();
                }
            }
        }
    }

    public function actionCancel() {
        echo "cancel";
    }

    public function actionThank() {
        pre($_POST, true);
    }

}
