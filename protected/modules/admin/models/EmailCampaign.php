<?php

/**
 * EmailCampaign class.
 */
class EmailCampaign extends CFormModel {

    public $subject;
    public $message;
    public $campaign_type;
    public $user_type;
    public $newsletter_category;
    public $email_list;

    public function rules() {
        return array(
            array('subject, message,campaign_type', 'required'),
            array('user_type', 'required', 'on' => 'normal_scenario'),
            array('newsletter_category', 'required', 'on' => 'newsletter_scenario'),
            array('email_list', 'required', 'on' => 'custom_email_scenario'),
            array('email_list', 'checkEmailList', 'on' => 'custom_email_scenario'),
            array('user_type,newsletter_category,email_list', 'safe'), // have to declare safe because of massive assignment
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'subject' => 'Subject',
            'message' => 'Message',
            'campaign_type' => 'Campaign Type',
            'email_list' => 'Email List',
        );
    }

    public function checkEmailList($attribute, $params) {
        $emails = $this->email_list;
        //convert email list to string to an array so we can loop through it using ";"  as a delimiter.
        $emails = explode(',', $emails);
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addError($attribute, "'$email' is not a valid email.");
            }
        }
    }

}
