<script src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>  
<script src="<?php echo base_url(); ?>/assets/ckeditor/adapters/jquery.js"></script>

<section class="content-header">
    <h1>
        Email Campaign 
        <small></small>
    </h1>
    <?php 
    if(Yii::app()->user->hasFlash('success'))
    {    
    ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         Mails Has Been Sent Successfully
    </div>
    <?php 
    }
    ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() . '/admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url() . '/admin/emailcampaign'; ?>"><i class="fa fa-dashboard"></i> Email Campaign</a></li>
        <li class="active">Add</li>
    </ol>
</section>
<section class="content">
    <script language="javascript">
        function campaignType(campaign_type)
        {
            if (campaign_type != '')
            {
                if (campaign_type == 'normal')
                {
                    $("#normal").show();
                    $("#newsletter").hide();
                }
                else if (campaign_type == 'newsletter')
                {
                    $("#newsletter").show();
                    $("#normal").hide();
                    $("#email_list").hide();
                    $("#EmailCampaign_user_type").val('');
                    $("#EmailCampaign_email_list").val('');
                }
            }
        }

        function showEmailField(user_type)
        {
            if (user_type != '')
            {
                if (user_type == 'custom_emails')
                {
                    $("#email_list").show();
                }
                else
                {
                    $("#email_list").hide();
                }
            }
        }


    </script>



    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Email Campaign</h3>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'email-campaign-form',
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => false
                    )
                ));
                ?>
                <div class="box-body">
                    <div class="form-group">

                        <div class="col-xs-12">
                            <?php
                            if (empty($model->campaign_type)) {
                                $model->campaign_type = 'normal';
                            }
                            ?>
                            <?php echo $form->labelEx($model, 'campaign_type'); ?><br>
                            <?php echo $form->radioButtonList($model, 'campaign_type', array('normal' => 'Normal', 'newsletter' => 'Newsletter'), array('separator' => '&nbsp;&nbsp;', 'onchange' => 'campaignType(this.value);')); ?>
                            <?php echo $form->error($model, 'campaign_type'); ?>
                        </div>

                    </div>
                    <div style="clear:both"></div>

                    <div class="form-group">
                        <?php
                        ?>
                        <div class="col-xs-12" id="normal" style="display:<?php echo ($model->campaign_type == 'normal') ? 'block' : 'none'; ?>">
                            <?php echo $form->labelEx($model, 'user_type'); ?>
                            <?php echo $form->dropDownList($model, 'user_type', array('' => 'Select User Type', 'all' => 'All', 'pending' => 'Pending', 'active' => 'Active', 'custom_emails' => 'Custom Emails'), array('class' => 'form-control', 'onchange' => 'showEmailField(this.value);')); ?>
                            <?php echo $form->error($model, 'user_type'); ?>
                        </div>
                        <div class="col-xs-12" id="newsletter" style="display:<?php echo ($model->campaign_type == 'newsletter') ? 'block' : 'none'; ?>">
                            <?php echo $form->labelEx($model, 'newsletter_category'); ?>
                            <?php echo $form->dropDownList($model, 'newsletter_category', $newsletter_category, array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'newsletter_category'); ?>
                        </div> 

                    </div>
                    <div style="clear:both"></div>


                    <div class="form-group">

                        <div class="col-xs-12" id="email_list" style="display:<?php echo ($model->user_type == 'custom_emails') ? 'block' : 'none'; ?>">
                            <?php echo $form->labelEx($model, 'email_list'); ?>
                            <?php echo $form->textField($model, 'email_list', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control', 'placeholder' => 'Enter comma separated emails. Eg. abc@gmail.com, def@gmail.com')); ?>
                            <?php echo $form->error($model, 'email_list'); ?>
                        </div>

                    </div>
                    <div style="clear:both"></div>

                    <div class="form-group">

                        <div class="col-xs-12">
                            <?php echo $form->labelEx($model, 'subject'); ?>
                            <?php echo $form->textField($model, 'subject', array('size' => '60', 'maxlength' => '128', 'class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'subject'); ?>
                        </div>

                    </div>
                    <div style="clear:both"></div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php echo $form->labelEx($model, 'message'); ?>
                            <?php echo $form->textArea($model, 'message', array('rows' => '10', 'cols' => '60', 'class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'message'); ?>
                        </div>
                    </div>


                </div>
                <div class="box-footer">
                    <?php echo CHtml::link('Back', array('/admin/version'), array("class" => 'btn btn-info pull-right', "style" => "margin-left:10px;")); ?>
                    <?php echo CHtml::submitButton('Send', array("class" => 'btn btn-info pull-right')); ?>
                </div>
                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
    <script>
        $('#EmailCampaign_message').ckeditor();
    </script>    
</section>