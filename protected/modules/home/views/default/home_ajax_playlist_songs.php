<?php
$baseUrl = Yii::app()->theme->baseUrl;
?>   
<div style="font-size: 20px;color: #fff;margin: 10px;"><?php  echo $playlist_name; ?></div>
<ul class="a_list">

            <?php
            if (!empty($playlist_songs)) {
                $count = 1;
                foreach ($playlist_songs as $song) {
                    ?>    
                    <li>
                        <div class="i_info"> 
                            <?php 
                                $src = $baseUrl."/img/alb1.jpg";
                                if(!empty($song->song_detail->album_art)):
                                    $src = $song->song_detail->album_art;
                                endif;
                            ?>
                            <img src="<?php echo $src; ?>" /> 
                            <span class="play_btn">
                                <i class="fa fa-play-circle-o" 
                                    data-song="<?php echo $song->song_detail->slug; ?>" 
                                <?php if($song->song_detail->type == 1): ?>
                                    data-type="song"
                                <?php else: ?>
                                    data-type="video"
                                <?php endif; ?>
                                ></i>
                            </span>
                           <?php $this->widget('SongWidget',array("song_id"=>$song->song_detail->id)); ?>
                        </div>
                        <div class="i_titel">
                            <div  class="it_m">
                                <h5><?php echo elipsis($song->song_detail->song_name, '..', 35); ?></h5>
                                <h6><?php echo elipsis($song->song_detail->artist_name, '..', 35); ?></h6>
                            </div>
                            <div  class="it_r"> 
                                <div class="bpm">
                                    BPM: <span><?php echo $song->song_detail->bpm; ?></span> 
                                </div>
                                <div class="key">
                                    KEY: <span><?php echo $song->song_detail->song_key; ?></span>
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