<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $id
 * @property string $type
 * @property string $state
 * @property string $user_id
 * @property string $client_id
 * @property string $total
 * @property string $create_time
 * @property string $update_time
 *
 * @property-read boolean $isNew
 * @property-read boolean $isFinished
 * 
 * The followings are the available model relations:
 * @property User $client
 * @property User $user
 * @property OrderItem[] $orderItems
 */
class Order extends EActiveRecord
{
    const TYPE_SALE = 1;
    const TYPE_DELIVERY = 2;
    
    public function getTypes() {
        return array(
            self::TYPE_SALE => 'Sales',
            self::TYPE_DELIVERY => 'Delivery',
        );
    }
    
    public function getTypeName() {
        return $this->types[$this->type];
    }
    
    private function getTypeClassMap() {
        return array(
            self::TYPE_DELIVERY => 'DeliveryOrder',
            self::TYPE_SALE => 'SalesOrder',
        );
    }
    
    /**
     * Add Support for checking states with properties like isNew and isFinished.
     * 
     * @param string $name 
     * @return mixed Depends on Name.
     */
    public function __get($name) {
        $stateNames = array_values($this->getStates());
        if(preg_match('/^is('.implode('|', $stateNames).')$/ui', $name, $matches))
        {
            $index = array_search($matches[1], $typeNames);
            $states = array_keys($stateNames);
            return $this->state == $states[$index];
        }
        return parent::__get($name);
    }
    
    /**
     * Gets the name of the current state.
     *
     * @return string
     */
    public function getStateName() {
        return $this->states[$this->state];
    }
    
    /**
     * Returns a list of the states asociated with theier names.
     *
     * @return array
     */
    public function getStates() {
        return array(
            self::STATE_NEW => 'New',
            self::STATE_FINISHED => 'Finished',
        );
    }
    
    const STATE_NEW = 1;
    const STATE_FINISHED = 2;
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
            ),
            'currentStatus' => array(
                'class' => 'AStateMachine',
                'defaultStateName' => self::STATE_NEW,
                'statename' => $this->state,
                'states' => array(
                    array(
                        'class' => 'OrderStateNew',
                        'name' => self::STATE_NEW,
                    ),
                    array(
                        'class' => 'OrderStateFinihed',
                        'name' => self::STATE_FINISHED,
                    ),
                ),
            ),
        );
    }
    
    protected function instantiate($attributes) {
        $classes = $this->getTypeClassMap();
        $class = $classes[$attributes['type']];
        $model = new $class(null);
        return $model;
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type,', 'required'),
			array('type, client_id, total', 'length', 'max'=>10),
            array('type', 'in', 'range' => array_keys($this->types)),
            array('client_id', 'exists', 'className' =>'User', 'attributeName'=>'id', 'allowEmpty'=>true,),
			array('state, user_id, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, client_id, total', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'User', 'client_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'orderItems' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
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
			'user_id' => 'User',
			'client_id' => 'Client',
			'total' => 'Total',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave() {
        if($this->scenario == 'insert')
            $this->user_id = Yii::app()->user->id;
        
        return parent::beforeSave();
    }
    
    public function generateTotal() {
        return $this
            ->getDbConnection()
            ->createCommand()
            ->select("sum(p.{$this->getProductPrizeAttribute()} * i.quantity)")
            ->from(OrderItem::model()->tableName().' i')
            ->join(Product::model()->tableName(). ' p', 'p.id = i.product_id')
            ->where('i.order_id=:order_id', array(
                ':order_id'=>$this->id,
            ))
            ->queryScalar();
    }
    
    public function getProductPrizeAttribute() {
        throw new CException('Use a derived class!');
    }
    
    public function getNewItem()
    {
        $item = new OrderItem;
        $item->order = $this;
        $item->order_id = $this->id;
        return $item;
    }
}