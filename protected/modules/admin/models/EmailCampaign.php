<?php

/**
 * EmailCampaign class.
 */
class EmailCampaign extends CFormModel
{
	public $subject;
	public $message;


	
	public function rules()
	{
		return array(
			array('subject, message', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'subject'=>'Subject',
                        'message'=>'Message',
		);
	}

	
}
