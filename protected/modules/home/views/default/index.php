<?php
$baseUrl = Yii::app()->theme->baseUrl;
?> 
<div class="red_bar">
    <ul class="sub_top">
        <li><a class="home_main_type select" id="home_just_added" data-type="home_just_added" href="javascript:void(0)">Just Added</a></li>
        <li><a class="home_main_type" id="home_trending" data-type="home_trending" href="javascript:void(0)">Trending</a></li>
        <li><a class="home_main_type" id="home_playlist" data-type="home_playlist" href="javascript:void(0)">Playlist</a></li>
    </ul>
    <div class="av_tab" id="home_song_type_container"> 
        <span id="audio"  class="audio_t active home_song_type">Audio</span>
        <span id="video"  class="video_t home_song_type">Video</span>
    </div>
</div>
<div class="slider_p">
    <div class="home-slider">
        <div class="item"> <img src="<?php echo $baseUrl; ?>/img/bg.jpg" />
            <div class="slider_con">
                <div class="bcon_top">
                    <h1>Free House Music, DJ Mixes & Uploads</h1>
                    <h5>Over half a million people use House-Mixes.com, join them today.</h5>
                </div>
                <div class="bcon_bottom">
                    <div class="b_col">
                        <div class="b_wrap">
                            <div class="tac"><i class="fa fa-upload"></i></div>
                            <h2>Upload & Share</h2>
                            <p>No limits or restrictions on DJ mix uploads, share your DJ mixes on a global scale as your profile page becomes your digital CV to showcase your music to users from all corners of the globe.</p>
                            <a class="bg_blue fc_white btn_small mart15" href="#">Upload »</a> </div>
                    </div>
                    <div class="b_col">
                        <div class="b_wrap">
                            <div class="tac"><i class="fa fa-users"></i></div>
                            <h2>Socialise & Network</h2>
                            <p>Interact with other DJs and music fans, with over half a million registered users we are a buzzing DJ social network enabling you to network and build a large fan base.</p>
                            <a class="bg_blue fc_white btn_small mart15" href="#">Socialise »</a> </div>
                    </div>
                    <div class="b_col">
                        <div class="b_wrap"> <i class="fa fa-play-circle"></i>
                            <h2>Stream & Download</h2>
                            <p>With over 300,000 uploaded mixes from every genre you can think of and over 200 new mixes uploaded daily there is more than enough music to get your teeth into!</p>
                            <a class="bg_blue fc_white btn_small mart15" href="#">Explore »</a> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item"> <img src="<?php echo $baseUrl; ?>/img/bg1.jpg" />
            <div class="slider_con">
                <div class="bcon_top">
                    <h1>Test House Music, DJ Mixes & Uploads</h1>
                    <h5>Over half a million people use House-Mixes.com, join them today.</h5>
                </div>
                <div class="bcon_bottom">
                    <div class="b_col">
                        <div class="b_wrap">
                            <div class="tac"><i class="fa fa-upload"></i></div>
                            <h2>Text 01</h2>
                            <p>No limits or restrictions on DJ mix uploads, share your DJ mixes on a global scale as your profile page becomes your digital CV to showcase your music to users from all corners of the globe.</p>
                            <a class="bg_blue fc_white btn_small mart15" href="#">Upload »</a> </div>
                    </div>
                    <div class="b_col">
                        <div class="b_wrap">
                            <div class="tac"><i class="fa fa-users"></i></div>
                            <h2>Text 02</h2>
                            <p>Interact with other DJs and music fans, with over half a million registered users we are a buzzing DJ social network enabling you.</p>
                            <a class="bg_blue fc_white btn_small mart15" href="#">Socialise »</a> </div>
                    </div>
                    <div class="b_col">
                        <div class="b_wrap"> <i class="fa fa-play-circle"></i>
                            <h2>Text 03</h2>
                            <p>With over 300,000 uploaded mixes from every genre you can think of and over 200 new mixes uploaded daily there is more than enough music to get your teeth into!</p>
                            <a class="bg_blue fc_white btn_small mart15" href="#">Explore »</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h_con">
    <div class="wraper" id="home_media_container">
        <ul class="a_list">
            <?php
            if (!empty($songs)) {
                $count = 1;
                foreach ($songs as $song) {
                    ?>    
                    <li>
                        <div class="i_info"> 
                            <?php 
                                $src = $baseUrl."/img/alb1.jpg";
                                if(!empty($song->album_art)):
                                    $src = $song->album_art;
                                endif;
                            ?>
                            <img src="<?php echo $src; ?>" /> 
                                <span class="play_btn">
                                    <i class="fa fa-play-circle-o" 
                                        data-song="<?php echo $song->slug; ?>" 
                                    <?php if($song->type == 1): ?>
                                        data-type="song"
                                    <?php else: ?>
                                        data-type="video"
                                    <?php endif; ?>
                                    ></i>
                                </span>
                            <?php $this->widget('SongWidget', array("song_id" => $song->id)); ?>
                        </div>
                        <div class="i_titel">
                            <!--<div class="it_l">
                                <?php // echo $count; ?>
                            <!--</div>-->
                            <div  class="it_m">
                                <h5>
                                    <a href="<?php echo base_url().'/media?name='.$song->slug; ?>"><?php echo elipsis($song->song_name, '..', 35); ?></a>
                                </h5>
                                <h6><?php echo elipsis($song->artist_name, '..', 35); ?></h6>
                            </div>
                            <div  class="it_r"> 
                                <div class="bpm">
                                    BPM: <span><?php echo $song->bpm; ?></span> 
                                </div>
                                <div class="key">
                                    KEY: <span><?php echo $song->song_key; ?></span>
                                </div>
                            </div>
                        </div>
                    </li>  


                    <?php
                    $count = $count + 1;
                }
            }
            ?>

        </ul>
    </div>
</div>
<script src="<?php echo base_url(); ?>/assets/js/home/home.js"></script>