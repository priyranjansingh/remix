<?php

/**
 * This is the model class for table "remix_media".
 *
 * The followings are the available columns in table 'remix_media':
 * @property string $id
 * @property string $song_name
 * @property string $artist_name
 * @property string $album_art
 * @property string $slug
 * @property string $initial_key
 * @property string $bpm
 * @property string $file_name
 * @property string $file_type
 * @property double $file_size
 * @property integer $type
 * @property string $genre
 * @property string $sub_genre
 * @property string $version
 * @property string $member_type
 * @property string $binary_data
 * @property integer $status
 * @property integer $deleted
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_entered
 * @property string $date_modified
 */
class RemixMedia extends AdminBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'remix_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, file_name, file_type, file_size, type, genre, version, binary_data, created_by, modified_by, date_entered, date_modified', 'required'),
			array('type, status, deleted', 'numerical', 'integerOnly'=>true),
			array('file_size', 'numerical'),
			array('id, genre, sub_genre, version, created_by, modified_by', 'length', 'max'=>36),
			array('song_name, artist_name, slug, initial_key, bpm, file_name', 'length', 'max'=>256),
			array('file_type', 'length', 'max'=>100),
			array('member_type', 'length', 'max'=>3),
			array('album_art', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, song_name, artist_name, album_art, slug, initial_key, bpm, file_name, file_type, file_size, type, genre, sub_genre, version, member_type, binary_data, status, deleted, created_by, modified_by, date_entered, date_modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'song_name' => 'Song Name',
			'artist_name' => 'Artist Name',
			'album_art' => 'Album Art',
			'slug' => 'Slug',
			'initial_key' => 'Initial Key',
			'bpm' => 'Bpm',
			'file_name' => 'File Name',
			'file_type' => 'File Type',
			'file_size' => 'File Size',
			'type' => 'Type',
			'genre' => 'Genre',
			'sub_genre' => 'Sub Genre',
			'version' => 'Version',
			'member_type' => 'Member Type',
			'binary_data' => 'Binary Data',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('song_name',$this->song_name,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('album_art',$this->album_art,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('initial_key',$this->initial_key,true);
		$criteria->compare('bpm',$this->bpm,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('type',$this->type);
		$criteria->compare('genre',$this->genre,true);
		$criteria->compare('sub_genre',$this->sub_genre,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('member_type',$this->member_type,true);
		$criteria->compare('binary_data',$this->binary_data,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('date_entered',$this->date_entered,true);
		$criteria->compare('date_modified',$this->date_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RemixMedia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
