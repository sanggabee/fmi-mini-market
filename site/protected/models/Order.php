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
            $index = array_search($matches[1], $stateNames);
            $states = array_keys($this->getStates());
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
			array('id, type, client_id, total, from, to, user_email', 'safe', 'on'=>'search'),
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

    public $from;
    public $to;
    public $user_email;
    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

        
        
		$criteria=new CDbCriteria;
        $alias = $this->getTableAlias(true, true);
        $criteria->with = array('user');
		$criteria->compare($alias.'.id',$this->id,true);
		$criteria->compare($alias.'.type',$this->type,true);
		$criteria->compare($alias.'.state',$this->state,true);
		$criteria->compare($alias.'.total',$this->total,true);
		$criteria->compare('user.email',$this->user_email,true);
		$criteria->compare($alias.'.create_time',$this->create_time,true);

        if(!empty($this->from ))
            $criteria->compare($alias.'.create_time', ">=$this->from 00:00:00", true);
        
        if(!empty($this->to))
            $criteria->compare($alias.'.create_time', "<=$this->to 23:59:59", true);
        
        
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
    
    public function getTotal()
    {
        $sum = 0;
        foreach($this->orderItems as $item) /* @var $item OrderItem */
            $sum += $item->rowTotal;
        
        if($this->total != $sum)
        {
            $this->total = $sum;
            $this->save();
        }
        
        return $sum;
    }
    
    public function applyStorigeDirection($quota) {
        throw new CException('Implemented in derived class!!!');
    }
    
    /**
     * Predicate for checking wether the order can be deleted or not.
     *
     * @return boolean
     */
    public function getCanBeDeleted() {
        return !OrderItem::model()->forOrder($this)->exists();
    }
    
    /**
     * Filters the orders by a specified state.
     *
     * @param integer $state One of STATE_* constants.
     * @return Order
     */
    public function inState($state) {
        return $this->attributeNamedScope('state', $state);
    }
    
    /**
     * Filters the orders added by a given user
     *
     * @param User $user
     * @return Order 
     */
    public function forUser($user) {
        return $this->attributeNamedScope('user_id', $user->id);
    }
    
    /**
     *
     * @return type 
     */
    public function getOverallTotal() {
        if(get_class($this) == 'Order')
            throw new CException('Do not use on base class Order! Behaviour is undefined!');

        $orders = $this->inState(self::STATE_FINISHED)->findAll();
        $sum = 0;
        foreach($orders as $order) /* @var $order Order */
            $sum += $order->total;
        
        return $sum;
    }
}
