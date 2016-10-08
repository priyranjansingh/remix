<section class="content-header">
    <h1>
        Subscribed Categories
    </h1>
    <ol class="breadcrumb">
	    <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	    <li><a href="<?php echo base_url() . '/admin/newsletteremails'; ?>"><i class="fa fa-dashboard"></i> Newsletter Emails</a></li>
	    <li class="active">View</li>
   </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                 <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                                <th>Category Name</th>
                            </tr>
                            <?php
                            if (!empty($model->category_list)) {
                                foreach ($model->category_list as $mapping) {
                                    ?>
                                    <tr>
                                        <td><?php echo $mapping->category_name->category; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>
                        </tbody></table>
                      <div class="col-xs-12">
                            <?php echo CHtml::link('Back', array('/admin/newsletteremail'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                      </div>
                </div>
            </div>
        </div>
    </div>
</section>