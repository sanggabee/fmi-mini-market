<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 'expression' => '$user->isAdmin || $user->isOperator',),
			array('deny', 'users'=>array('*'),),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $this->layout = false;
		$model=new Product;
		$this->performAjaxValidation($model);
        
		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if($model->save())
            {
                $message = Yii::t('app', 'Successfuly created {item_name}!', array(
                    '{item_name}' => Yii::t('app', 'product'),
                ));
                $this->user->setFlash('success', $message);
                $this->refresh();
            }
		}
        
        $this->render('_form', array_merge($this->getNeededDataLists(), array(
			'model'=>$model,
		)));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        $this->layout = false;
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if($model->save())
            {
				$message = Yii::t('app', 'Successfuly updated {item_name}!', array(
                    '{item_name}' => Yii::t('app', 'product'),
                ));
                $this->user->setFlash('success', $message);
                $this->refresh();
            }
		}

		$this->render('_form', array_merge($this->getNeededDataLists(), array(
			'model'=>$model,
		)));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

        $this->render('admin', array_merge($this->getNeededDataLists(), array(
			'model'=>$model,
		)));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
     * @return Product
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
        
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    /**
     * Helper method used in update, create and andmin actions for 
     * extracting select boxes data for manifacturer, category and measure.
     *
     * @return array
     */
    private function getNeededDataLists() 
    {
        return array(
            'manifacturers' => Manifacturer::model()->listData,
            'categories' => Category::model()->listData,
            'measures' => Measure::model()->listData,
        );
    }
}
