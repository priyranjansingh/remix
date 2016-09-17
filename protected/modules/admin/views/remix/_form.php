<div class="box-body">
    <!-- For jquery file upload  -->
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery_file_uploader/css/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery_file_uploader/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery_file_uploader/css/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery_file_uploader/css/jquery.fileupload-ui-noscript.css"></noscript>

    <!-- for autocomplete -->

    <script type="text/javascript" src="<?php echo base_url(); ?>/assets/autocomplete/dist/js/select2.full.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>/assets/autocomplete/vendor/js/bootstrap.min.js"></script>


    <link href="<?php echo base_url(); ?>/assets/autocomplete/css/bootstrap.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/autocomplete/dist/css/select2.min.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/autocomplete/css/font-awesome.css" type="text/css" rel="stylesheet" />

   <!-- end of autocomplete -->
   
   <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/remix/remix.js"></script>

    


    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload_remix" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-xs-12">
                <label for="parent_original_songs" class="required">Search the original song here: <span class="required">*</span></label>
                <select id="parent_original_songs" class="form-control" multiple="multiple">
                </select>
                <div id="source_song_err" class="errorMessage" style="display:none">Source song can not be empty .</div>
                <script>
                    $("#parent_original_songs").select2({
                        ajax: {
                            url: base_url + "/admin/remix/searchoriginal",
                            dataType: 'json',
                            data: function(params) {
                                return {
                                    q: params.term  // search term
                                };
                            },
                        },
                        minimumInputLength: 2,
                    });
                </script>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-6 remix_genre_container" >
                <label for="genre" class="required">Genre: <span class="required">*</span></label>
                <select id="remix_genre" class="form-control">
                    <option value="">Select Genre</option>
                    <?php
                    if (!empty($genre_arr)) {
                        foreach ($genre_arr as $k => $v) {
                            ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>   
                <div id="remix_genre_err" class="errorMessage" style="display:none">Genre can not be empty .</div>
            </div>
            <div class="col-xs-6 remix_version_container">
                <label for="subgenre" class="required">Subgenre: </label>
                <select id="remix_subgenre" class="form-control">
                    <option value="">Select Subgenre</option>
                </select>   
            </div>

        </div>    
        
        <div class="form-group">
            <div class="col-xs-6 remix_version_container">
                <label for="version" class="required">Version: <span class="required">*</span></label>
                <select id="remix_version" class="form-control">
                    <option value="">Select Version</option>
                    <?php
                    if (!empty($version_arr)) {
                        foreach ($version_arr as $k => $v) {
                            ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>  
                <div id="remix_version_err" class="errorMessage" style="display:none">Version can not be empty .</div>
            </div>
             
            <div class="col-xs-6 remix_member_type_container">
                <label for="member_type" class="required">Member Type: <span class="required">*</span></label>
                <select id="member_type" class="form-control">
                    <option value="reg" selected="selected">REG</option>
                    <option value="vip">VIP</option>
                </select>  
            </div>
            
        </div>    


        <div class="form-group">
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="col-xs-12 fileupload-buttonbar" id="remix_uploader">
                <div class="col-lg-7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Add files...</span>
                        <input type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel upload</span>
                    </button>
                    <button type="button" class="btn btn-danger delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" class="toggle">
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table> 
        </div>
    </form>



    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
        <td>
        <span class="preview"></span>
        </td>
        <td>
        <p class="name">{%=file.name%}</p>
        <strong class="error text-danger"></strong>
        </td>
        <td>
        <p class="size">Processing...</p>
        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
        {% if (!i && !o.options.autoUpload) { %}
        <button class="btn btn-primary start" disabled>
        <i class="glyphicon glyphicon-upload"></i>
        <span>Start</span>
        </button>
        {% } %}
        {% if (!i) { %}
        <button class="btn btn-warning cancel">
        <i class="glyphicon glyphicon-ban-circle"></i>
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
        <td>
        {% if (file.deleteUrl) { %}
        <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
        <i class="glyphicon glyphicon-trash"></i>
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <script src="<?php echo base_url(); ?>/assets/jquery_file_uploader/js/main.js"></script>
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
</div>