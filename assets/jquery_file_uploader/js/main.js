/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function() {
    'use strict';

  $('#fileupload').bind('fileuploadsubmit', function(e, data) {
        // The example input, doesn't have to be part of the upload form:
        var genre = $("#original_genre").val();
        var sub_genre = $("#original_subgenre").val();
        var version = $("#original_version").val();
        data.formData = {genre: genre,sub_genre:sub_genre, version: version};
        validateOriginalUpload(genre, version);
    }).fileupload({
        url: base_url + '/admin/originalsong/upload',
    });




    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                    )
            );



    $('#fileupload_remix').bind('fileuploadsubmit', function(e, data) {
        // The example input, doesn't have to be part of the upload form:
        var parent_songs = $("#parent_original_songs").val();
        var genre = $("#remix_genre").val();
        var sub_genre = $("#remix_subgenre").val();
        var version = $("#remix_version").val();
        var member_type = $("#member_type").val();
        data.formData = {parent_songs: parent_songs, genre: genre,sub_genre:sub_genre, version: version, member_type:member_type};
        validateUpload(parent_songs, genre, version);
    }).fileupload({
        url: base_url + '/admin/remix/upload',
    });




    // Enable iframe cross-domain access via redirect option:
    $('#fileupload_remix').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                    )
            );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload_remix').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function() {
                $('<div class="alert alert-danger"/>')
                        .text('Upload server currently unavailable - ' +
                                new Date())
                        .appendTo('#fileupload_remix');
            });
        }
    }



});



function validateUpload(parent_songs, genre, version)
{
    var parent_flag, genre_flag, version_flag = true;
    if (!parent_songs)
    {
        parent_flag = false;
        $("#source_song_err").show();
    }
    else
    {
        parent_flag = true;
        $("#source_song_err").hide();
    }


    if (!genre)
    {
        genre_flag = false;
        $("#remix_genre_err").show();
    }
    else
    {
        genre_flag = true;
        $("#remix_genre_err").hide();
    }


    if (!version)
    {
        version_flag = false;
        $("#remix_version_err").show();
    }
    else
    {
        version_flag = true;
        $("#remix_version_err").hide();
    }

    if (parent_flag == true && genre_flag == true && version_flag == true)
    {
        return true;
    }
    else
    {
        return false;
    }


}

function validateOriginalUpload(genre, version)
{
    var genre_flag, version_flag = true;
    
    if (!genre)
    {
        genre_flag = false;
        $("#original_genre_err").show();
    }
    else
    {
        genre_flag = true;
        $("#original_genre_err").hide();
    }


    if (!version)
    {
        version_flag = false;
        $("#original_version_err").show();
    }
    else
    {
        version_flag = true;
        $("#original_version_err").hide();
    }

    if (genre_flag == true && version_flag == true)
    {
        return true;
    }
    else
    {
        return false;
    }


}
