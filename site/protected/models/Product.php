<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $category_id
 * @property string $manifacturer_id
 * @property string $measure_id
 * @property string $name
 * @property string $delivery_prize
 * @property string $sell_prize
 * @property string $current_quantity
 * @property string $minimum_quantity
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property OrderItem[] $orderItems
 * @property Category $category
 * @property Manifacturer $manifacturer
 * @property Measure $measure
 */
class Product extends EActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, manifacturer_id, measure_id, name, delivery_prize, sell_prize, current_quantity, minimum_quantity', 'required'),
			array('category_id, manifacturer_id, measure_id, delivery_prize, sell_prize, current_quantity, minimum_quantity', 'length', 'max'=>10),
            array('category_id', 'exist', 'className'=>'Category', 'attributeName' => 'id'),
            array('manifacturer_id', 'exist', 'className'=>'Manifacturer', 'attributeName' => 'id'),
            array('measure_id', 'exist', 'className'=>'Measure', 'attributeName' => 'id'),
            array('delivery_prize, sell_prize, current_quantity, minimum_quantity', 'numerical', 'min'=>0, 'max'=>1000000,),
            array('delivery_prize', 'compare', 'compareAttribute' => 'sell_prize', 'operator'=>'<', ),
            array('sell_prize', 'compare', 'compareAttribute' => 'delivery_prize', 'operator'=>'>', ),
			array('name', 'length', 'max'=>100),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, manifacturer_id, measure_id, name, delivery_prize, sell_prize, current_quantity, minimum_quantity, create_time, update_time', 'safe', 'on'=>'search'),
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
			'orderItems' => array(self::HAS_MANY, 'OrderItem', 'product_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'manifacturer' => array(self::BELONGS_TO, 'Manifacturer', 'manifacturer_id'),
			'measure' => array(self::BELONGS_TO, 'Measure', 'measure_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'manifacturer_id' => 'Manifacturer',
			'measure_id' => 'Measure',
			'name' => 'Name',
			'delivery_prize' => 'Delivery Prize',
			'sell_prize' => 'Sell Prize',
			'current_quantity' => 'Current Quantity',
			'minimum_quantity' => 'Minimum Quantity',
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
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('manifacturer_id',$this->manifacturer_id,true);
		$criteria->compare('measure_id',$this->measure_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('delivery_prize',$this->delivery_prize,true);
		$criteria->compare('sell_prize',$this->sell_prize,true);
		$criteria->compare('current_quantity',$this->current_quantity,true);
		$criteria->compare('minimum_quantity',$this->minimum_quantity,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
            ),
        );
    }
}