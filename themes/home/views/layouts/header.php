<div class="header">
    <div class="col-md-2 logo_p">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo $baseUrl; ?>/img/logo.png" /></a>
    </div>
    <div class="col-md-10">
        <div class="togg_bar"><span class="togg_menu"><i class="fa fa-navicon"></i></span></div>
        <ul class="h_menu">
            <li>
                <span class="search">
                     <?php $this->widget('SearchWidget'); ?>
                </span>
            </li>
            <li><a href="#"><i class="fa fa-th-large"></i> <span id="category_name" data-genre="" class="">Categories</span> <i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu sub_menu">
                    <?php $genres = Genres::model()->findAll(array("condition" => "parent = '0'")); ?>

                    <?php foreach($genres as $genre): ?>
                        <li><a class="genre_class" data-name="<?php echo $genre->name; ?>"  data-genre="<?php  echo $genre->id;  ?>"  href="javascript:void(0)"><?php echo $genre->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php if(Yii::app()->user->isGuest): ?>
            <li><a href="#" data-toggle="modal" data-target="#Signup-pop">Sign Up</a></li>
            <li><a href="#" data-toggle="modal" data-target="#Login-pop">Login</a></li>
            <?php else: ?>
            <li><a href="#" data-toggle="modal" data-target="#Upload-pop"><i class="fa fa-cloud-upload"></i> Upload</a></li>
            <li><a href="#"><?php echo Users::model()->findByPk(Yii::app()->user->id)->username; ?> <i class="fa fa-angle-down"></i></a>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url().'/user/profile'; ?>">My Profile</a></li>
                     <li><a href="<?php echo base_url().'/user/drive'; ?>">My Drive</a></li>
                      <li><a href="<?php echo base_url().'/user/plans'; ?>">My Plans</a></li>
                    <li><a href="<?php echo base_url().'/user/paymenthistory'; ?>">Payment History</a></li>
                      <li><a href="<?php echo base_url().'/user/changepassword'; ?>">Change Password</a></li>
                    <li><a href="<?php echo base_url().'/home/logout'; ?>">Logout</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <li><a href="#">More <i class="fa fa-angle-down"></i></a>
                <ul class="sub_menu">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>