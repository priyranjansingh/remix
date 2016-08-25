<?php
if (!empty($playlist)) {
    foreach ($playlist as $plist) {
        ?> 
        <!--<div class="row">
            <div class="col-md-12 pad-16">
                <a class="selected_playlist" data-song="<?php echo $song_id; ?>" data-playlist="<?php // echo $plist->id; ?>" href="javascript:void(0)"> 
                    <?php // echo $plist->name; ?> 
                </a>
            </div>
        </div>-->
        <div class="verticalScrollPlaylist">
                <div class="scrolldivcl">
                        <div class="_playlist_list playlistname dotes">
                            <a class="selected_playlist" data-song="<?php echo $song_id; ?>" data-playlist="<?php echo $plist->id; ?>" href="javascript:void(0)">
                                <i class="fa fa-list"></i> <?php echo $plist->name; ?> 
                            </a>
                        </div>
                </div>
        </div>
        

        <?php
    }
}
else 
{
?>    
    <div class="m_row">
            <div class="mr_col">
                No Playlist Added Yet       
            </div>
        </div>
<?php
}    
?>





