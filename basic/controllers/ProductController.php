<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {	
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => 
				[	
					[
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'parse', 'parse-all'],
						'allow' => true,
						'roles' => ['@'],
						/*
						'matchCallback' => function ($rule, $action) 
						{
							return Yii::$app->user->identity->IsAdmin;
						}
						*/
					],					
				],
			],			
		
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
					'parse-all' => ['post'],					
                ],
            ],
        ];
    }
	
	public function actionParseAll () {		
		$error_count = ParserController::ParseProductAll();		
		if ($error_count > 0) 
			Yii::$app->session->setFlash('error', Yii::t('app', 'Parsing operation ended with errors (count = {errorCount})', ['errorCount' => $error_count]));
		else
			Yii::$app->session->setFlash('success', Yii::t('app', 'Parsing operation complete'));
		return $this->redirect(Yii::$app->request->referrer);
	}	
	
	public function actionParse ($id) {
		$model = $this->findModel($id);
		$error_count = ParserController::ParseProduct($id);		
		if ($error_count > 0) 
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Parsing operation ended with errors (count = {errorCount})', ['errorCount' => $error_count]));
		else
			Yii::$app->session->setFlash('success', Yii::t('app', 'Parsing operation complete'));
		return $this->redirect(Yii::$app->request->referrer);
	}	

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->orderby(['title' => SORT_ASC]);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);		
		$settings = Yii::$app->user->identity;		
		$forecast_dataset = $model->getProductCostForecast(date('Y-m-d'), $settings->forecast_data_size,  $settings->forecast_size,  $settings->forecast_alpha, $settings->forecast_beta);				
		
        return $this->render('view', [
            'model' => $model,
			'forecast_dataset' => $forecast_dataset,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
