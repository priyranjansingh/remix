<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>JOCKDRIVE</title>

        <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
        Yii::app()->clientScript->registerCoreScript('jquery');
        ?>

        <!--Css-->
        <link href="<?php echo $baseUrl; ?>/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/chosen.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/jquery.fileupload.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/owl.carousel.css" rel="stylesheet" type="text/css">
        <!-- <link href="<?php echo $baseUrl; ?>/css/jplayer.pink.flag.css" rel="stylesheet" type="text/css"> -->
        <link href="<?php echo $baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/developer.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/membership.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $baseUrl; ?>/css/responsive.css" rel="stylesheet" type="text/css">

        <!-- jquery -->
        <script src="<?php echo $baseUrl; ?>/js/chosen.jquery.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/bootstrap.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/owl.carousel.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/jquery.jplayer.min.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/jplayer.playlist.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/custom.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/songwidget.js"></script>
        <script>
            var base_url = "<?php echo base_url(); ?>";
            $(document).ready(function(){
               $("#forgot_pass_link").click(function(){
                   $("#ForgotPassword_username").val('');
                   $("#forgot_form").show();
                   $("#forgot_message").hide();
               }) 
            });
        </script>    
    </head>

    <body>
        <!--Header-->
        <?php require_once('header.php'); ?>
        <!--Header--> 
        <!--Content-->
        <?php echo $content; ?>
        <!--Content--> 
        <!--Footer-->
        <?php require_once('footer.php'); ?>
        <!--Footer--> 

        <!--popup-->
        <div class="modal fade" id="Upload-pop">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Upload File</h4>
                    </div>
                    <div class="modal-body">
                        <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-8">
                                    <p>Choose How Files Will be uploaded Privately or Public.</p>
                                    <input type="radio" name="file_mode" class="file_mode" checked="checked" value="authenticated-read" />Public
                                    <input type="radio" name="file_mode" class="file_mode" value="private" />Private
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                            <noscript>
                            <input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/">
                            </noscript>
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="row fileupload-buttonbar">
                                <div class="col-lg-8"> 
                                    <!-- The fileinput-button span is used to style the file input field as button --> 
                                    <span class="btn btn-success fileinput-button"> <i class="fa fa-plus"></i> <span>Add files...</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                    <button type="submit" class="btn btn-primary start"> <i class="fa fa-arrow-circle-o-up"></i> <span>Start upload</span> </button>
                                    <button type="reset" class="btn btn-warning cancel"> <i class="fa fa-ban"></i> <span>Cancel upload</span> </button>
                                    <button type="button" class="btn btn-danger delete"> <i class="fa fa-trash"></i> <span>Delete</span> </button>
                                    <input type="checkbox" class="toggle">
                                    <!-- The global file processing state --> 
                                    <span class="fileupload-process"></span> </div>
                                <!-- The global progress state -->
                                <div class="col-lg-4 fileupload-progress fade"> 
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <!-- The extended global progress state -->
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table utable">
                                <tbody class="files">
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="Signup-pop">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">SIGN UP JOCKDRIVE</h4>
                    </div>
                    <div class="modal-body">
                        <?php $this->widget('SignupWidget'); ?>
                    </div>
                    <div class="modal-footer"> 
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>--> 
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="widget_success_upload">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Notification</h4>
                    </div>
                    <div class="modal-body">
                        Successfully Added To Your Drive.
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Login-pop">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">LOGIN</h4>
                    </div>
                    <div class="modal-body">
                        <?php $this->widget('LoginWidget'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Forgotpass">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Recover Password</h4>
                    </div>
                    <div class="modal-body">
                        <div id="forgot_form">
                            <?php $this->widget('ForgotpassWidget'); ?>
                        </div> 
                        <div id="forgot_message"  style="display:none">
                            <div id="success_message" class="alert alert-success"></div>
                            <div class="m_row tac">New to JOCKDRIVE? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#Signup-pop">Sign Up</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="ajax_add_playlist">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add To Playlist</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-header" style="margin-bottom: 50px;"></div>
                    <div>
                        <?php $this->widget('AddPlaylistWidget'); ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="edit_song_div">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Song Information</h4>
                    </div>
                    <div class="modal-body" id="edit_song_div_body">
                    </div>
                    <div class="modal-footer"> 
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="delete_song_div">
            <div class="modal-dialog" role="document">
                <div class="modal-content log_pan">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Want to delete this song?</h4>
                    </div>
                    <div class="modal-body" id="delete_song_div_body">
                        <input id="delete_yes" type="button" value="Yes" data-song="" class="btn_small bg_blue delete_option">
                        <input id="delete_no" type="button" value="No" data-song="" class="btn_small bg_blue delete_option">
                    </div>
                    <div class="modal-footer"> 
                    </div>
                </div>
            </div>
        </div>




        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
            <td colspan="2" class="filename">
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
            </td>
            <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td class="last">
            {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-primary start" disabled>
            <i class="fa fa-arrow-circle-o-up"></i>
            <span>Start</span>
            </button>
            {% } %}
            {% if (!i) { %}
            <button class="btn btn-warning cancel">
            <i class="fa fa-ban"></i>
            <span>Cancel</span>
            </button>
            {% } %}
            </td>
            </tr>
            {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
            <td>
            <span class="preview">
            {% if (file.thumbnailUrl) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
            {% } %}
            </span>
            </td>
            <td>
            <p class="name">
            {% if (file.url) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %}
            <span>{%=file.name%}</span>
            {% } %}
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
            </td>
            <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td class="last">
            {% if (file.deleteUrl) { %}
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="fa fa-trash"></i>
            <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
            <button class="btn btn-warning cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel</span>
            </button>
            {% } %}
            </td>
            </tr>
            {% } %}
        </script>
        <script>
            var base_url = "<?php echo base_url(); ?>";
        </script>
        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="<?php echo $baseUrl; ?>/js/vendor/jquery.ui.widget.js"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
        <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->

        <!-- blueimp Gallery script -->
        <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload.js"></script>
        <!-- The File Upload processing plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload-process.js"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload-image.js"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload-audio.js"></script>
        <!-- The File Upload video preview plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload-video.js"></script>
        <!-- The File Upload validation plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload-validate.js"></script>
        <!-- The File Upload user interface plugin -->
        <script src="<?php echo $baseUrl; ?>/js/jquery.fileupload-ui.js"></script>
        <!-- The main application script -->
        <script src="<?php echo $baseUrl; ?>/js/main.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/jquery-ui.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/common.js"></script>
        <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
        <!--[if (gte IE 8)&(lt IE 10)]>
        <script src="js/cors/jquery.xdr-transport.js"></script>
        <![endif]-->

        <span class="loading"></span>
    </body>
</html>
