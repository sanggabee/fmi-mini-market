<?php
/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property integer $type
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class User extends EActiveRecord
{
    const TYPE_ADMIN = 1;
    const TYPE_OPERATOR = 2;
    const TYPE_CLIENT = 3;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, email, password, first_name, last_name', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>250),
			array('password', 'length', 'max'=>40),
			array('first_name, last_name', 'length', 'max'=>50),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, email, password, first_name, last_name, create_time, update_time', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'client_id'),
			'orders1' => array(self::HAS_MANY, 'Order', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'email' => 'Email',
			'password' => 'Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Generates the fill name of a user based on his first and last names.
     *
     * @return string
     */
    public function getFullName() {
        return "$this->first_name $this->last_name";
    }
    
    /**
     * Checks wether the $password has the same hash as the one in DB.
     *
     * @param string $password Password to check
     * @return boolean Comparison result.
     */
    public function validatePassword($password) {
        return $this->password == $this->hashPassword($password);
    }
    
    /**
     * Hashes a given plain password.
     *
     * @param string $password
     * @return string
     */
    public function hashPassword($password) {
        return sha1(Yii::app()->params['userSalt'].$password);
    }
    
    
}