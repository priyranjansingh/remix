<?php

class Registration extends BaseModel {

    /**
     * @return string the associated database table name
     */
    public $confirm_password;
    public $terms;

    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, password,confirm_password,username,email, role_id, created_by, date_entered', 'required'),
            array('username,email','unique'),
            array('confirm_password', 'compare', 'compareAttribute'=>'password'),
            array('state_id, country_id, is_admin, status, deleted', 'numerical', 'integerOnly' => true),
            array('id, role_id, created_by, modified_by', 'length', 'max' => 36),
            array('username, first_name, last_name', 'length', 'max' => 128),
            array('username, password, confirm_password','length', 'min' => 6),
            array('password, email', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 16),
            array('profile_pic', 'length', 'max' => 256),
            array('date_modified', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, first_name, last_name, email, phone, profile_pic, state_id, country_id, is_admin, role_id, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'profile_pic' => 'Profile Pic',
            'state_id' => 'State',
            'country_id' => 'Country',
            'is_admin' => 'Is Admin',
            'role_id' => 'Role',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('profile_pic', $this->profile_pic, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('is_admin', $this->is_admin);
        $criteria->compare('role_id', $this->role_id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_by', $this->modified_by, true);
        $criteria->compare('date_entered', $this->date_entered, true);
        $criteria->compare('date_modified', $this->date_modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Registration the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
