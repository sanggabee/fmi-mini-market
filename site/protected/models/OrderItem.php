<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property string $id
 * @property string $product_id
 * @property string $order_id
 * @property string $quantity
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends EActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderItem the static model class
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
		return 'order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, order_id, quantity', 'required'),
			array('product_id, order_id, quantity', 'length', 'max'=>10),
			array('create_time', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, order_id, quantity, create_time', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'order_id' => 'Order',
			'quantity' => 'Quantity',
			'create_time' => 'Create Time',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getSinglePrize() {
        $name = $this->order->getProductPrizeAttribute();
        return $this->product->getAttribute($name);
    }
    
    public function getRowTotal() {
        return $this->quantity * $this->singlePrize;
    }
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'updateAttribute' => null,
            ),
        );
    }
    
    public function changeProductQuantity() {
        $changeBy = $this->order->applyStorigedirection($this->quantity);
        if($this->product->current_quantity + $changeBy < 0)
            throw new Exception("Not enough quantity in product {$this->product->name}.");
        
        return $this->product->saveCounters(array(
            'current_quantity' => $changeBy,
        ));
    }
    
    /**
     * Named scope for filtering items for an order.
     * 
     * @param Order $order 
     * @return OrderItem
     */
    public function forOrder($order) {
        return $this->attributeNamedScope('order_id', $order->id);
    }
    
    /**
     * Named scope for filtering items for an product.
     * 
     * @param Product $order 
     * @return OrderItem
     */
    public function forProduct($product) {
        return $this->attributeNamedScope('product_id', $product->id);
    }
    
    public function getCanBeDeleted() {
        return $this->order->isNew;
    }
}