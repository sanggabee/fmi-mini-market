<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $name
 * @property string $colour
 * @property string $picture
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property-read boolean $productsCount
 */
class Category extends EActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        
        // #abcdef
		return array(
			array('name, colour', 'required'),
			array('name, colour', 'length', 'max'=>45),
            array('colour', 'match', 'pattern'=>'/^#[a-f0-9]{6,6}$/ui'),
            array('colour', 'unique'),
			array('picture', 'length', 'max'=>255),
			array('picture', 'EImageValidator', 
                'maxSize'=>1024 * 1024 * 2, 
//                'maxWidth' => 200, 
//                'maxHeight' => 200, 
                'tooLarge'=>'Uploaded file is larger than 2 MB!',
                'allowEmpty' => $this->scenario != 'insert',
            ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, colour, picture', 'safe', 'on'=>'search'),
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
            'productsCount' => array(self::STAT, 'Product', 'category_id',),
			'products' => array(self::HAS_MANY, 'Product', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'colour' => 'Colour',
			'picture' => 'Picture',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with = array('productsCount');
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Checks wether the category can be deleted.
     *
     * @return boolean
     */
    public function getCanBeDeleted() {
        return ! $this->productsCount;
    }
    
    /**
     * Generates absolute filesystem picture path.
     *
     * @param string $name Optional name for the picture. Defaults to null -> using picture property;
     * @return string 
     */
    public function getPicturePath($name) {
        return $this->_getPicturepath(Yii::getPathOfAlias('webroot'), DIRECTORY_SEPARATOR, $name);
    }
    
    /**
     * Generates picture URL.
     * 
     * @param boolean $absolute Wether to generate absolute URL. Defaults to false.
     * @return string 
     */
    public function getPictureUrl($absolute = false) {
        return $this->_getPicturepath(Yii::app()->getBaseUrl($absolute), '/');
    }
    
    /**
     * Private helper method for generating picture paths.
     *
     * @param string $initial Initial part of the path(path to web root for example).
     * @param string $ds Directory separator
     * @param type $name Optional name for the picture.
     * @return type 
     */
    private function _getPicturepath($initial, $ds, $name=null)
    {
        if($name === null)
            $name = $this->picture;
        
        $directory = $initial . $ds . Yii::app()->params['uploadsDirectory'] . $ds . __CLASS__;
        return $directory . $ds . $name;
    }
    
    public function beforeValidate() {
        if(in_array($this->scenario, array('insert', 'update')))
            $this->picture = CUploadedFile::getInstance($this, 'picture');
        
        return parent::beforeValidate();
    }
    
    public function afterSave() {
        
        if($this->picture instanceof CUploadedFile && $this->picture->error == UPLOAD_ERR_OK){
            $name = "picture{$this->id}.{$this->picture->extensionName}";
            $this->picture->saveAs($this->getPicturePath($name));
            $this->updateByPk($this->id, array('picture'=>$name,));
        }
        parent::afterSave();
    }
    
    public function removePicture() {
        $this->setScenario('removePicture');
        $this->picture = null;
        if($this->save())
            $this->_deletePicture();
    }
    
    /**
     * 
     */
    public function afterDelete() {
        $this->_deletePicture();
        parent::afterDelete();
    }
    
    /**
     * Delete picture as a file.
     */
    private function _deletePicture() {
        @unlink($this->getPicturePath());
    }
}