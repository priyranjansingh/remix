$(document).ready(function() {


    $("body").on("click", ".widget_upload", function() {
        $(".loading").show();
        var song_id = $(this).data('song');
        var user_id = $(this).data('user'); //logged in user id
        $.ajax({
            url: base_url + "/home/LoginCheck",
            success: function(data) {
                if (data == 'GUEST')
                {
                    $(".loading").hide();
                    $("#Login-pop").modal('show');
                }
                else if (data == 'USER')
                {
                    $.ajax({
                        url: base_url + "/home/WidgetUpload",
                        method: "POST",
                        dataType: "json",
                        data: {'song_id': song_id, 'user_id': user_id},
                        success: function(data) {
                            $('#widget_success_upload').find('.modal-body').html(data.message);
                            $('#widget_success_upload').modal('show');
                            $(".loading").hide();
                        }
                    })
                }
            }
        })

    })

    $("body").on("click", ".widget_like", function() {
        $(".loading").show();
        var song_id = $(this).data('song');
        var user_id = $(this).data('user');
        var container = $(this);
        $.ajax({
            url: base_url + "/home/LoginCheck",
            success: function(data) {
                if (data == 'GUEST')
                {
                    $(".loading").hide();
                    $("#Login-pop").modal('show');
                }
                else if (data == 'USER')
                {
                    $.ajax({
                        url: base_url + "/home/WidgetLike",
                        method: "POST",
                        data: {'song_id': song_id, 'user_id': user_id},
                        success: function(data) {
                            container.find('span').html(data);
                            $(".loading").hide();
                        }
                    })
                }
            }
        })

    })

    $("body").on("click", ".widget_download", function() {
        var song_id = $(this).data('song');
        $.ajax({
            url: base_url + "/home/LoginCheck",
            success: function(data) {
                if (data == 'GUEST')
                {
                    $(".loading").hide();
                    $("#Login-pop").modal('show');
                }
                else if (data == 'USER')
                {
                    window.location.href = base_url + "/home/WidgetDownload?file=" + song_id;
                }
            }
        })



    });

    $("body").on("click", ".widget_playlist", function() {
        $(".loading").show();
        var song_id = $(this).data('song');
        $.ajax({
            url: base_url + "/home/LoginCheck",
            success: function(data) {
                if (data == 'GUEST')
                {
                    $(".loading").hide();
                    $("#Login-pop").modal('show');
                }
                else if (data == 'USER')
                {
                    $.ajax({
                        url: base_url + "/home/WidgetAddToPlaylist",
                        method: "POST",
                        data: {'song_id': song_id},
                        success: function(data) {
                            $('#ajax_add_playlist').find(".modal-body").html(data);
                            $("#playlist_song").val(song_id);
                            $('#ajax_add_playlist').modal('show');
                            $(".loading").hide();
                        }
                    })
                }
            }
        })

    })

    $("body").on("click", ".selected_playlist", function() {
        $(".loading").show();
        var song = $(this).data('song');
        var playlist = $(this).data('playlist');
        $.ajax({
            url: base_url + "/home/AjaxAddToPlaylist",
            method: "POST",
            data: {'song': song, 'playlist': playlist},
            success: function(data)
            {
                $('#ajax_add_playlist').modal('hide');
                $(".loading").hide();
            }

        })
    });



})