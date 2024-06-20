<?php

namespace app\controllers;

use Yii;
use app\models\Link;
use app\models\LinkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LinkController implements the CRUD actions for Link model.
 */
class LinkController extends Controller
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
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'parse', 'setup-as-main-link'],
						'allow' => true,
						'roles' => ['@'],						
						'matchCallback' => function ($rule, $action) 
						{
							return Yii::$app->user->identity->IsAdmin;
						}						
					],					
				],
			],			
		
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	
	public function actionSetupAsMainLink ($id) {
		$model = $this->findModel($id);
		$model->SetupAsMainLink();
		//return $this->redirect(['view', 'id' => $model->id]);
		return $this->redirect(Yii::$app->request->referrer);
	}	
	
	
	
	public function actionParse ($id) {
		$model = $this->findModel($id);
		ParserController::ParseLink($id, true);
		//return $this->redirect(['view', 'id' => $model->id]);
		return $this->redirect(Yii::$app->request->referrer);
	}	
	
    /**
     * Lists all Link models.
     * @return mixed
     */
    public function actionIndex($id_product)
    {
		$product = ProductController::findModel($id_product);
        $searchModel = new LinkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->where(['id_product' => $product->id]);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'product' => $product,
        ]);
    }

    /**
     * Displays a single Link model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		
		
		$model = $this->findModel($id);
		
		$product = ProductController::findModel($model->id_product);
        return $this->render('view', [
            'model' => $model,
			'product' => $product,
        ]);
    }

    /**
     * Creates a new Link model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_product)
    {
		$product = ProductController::findModel($id_product);
        $model = new Link();
		$model->id_product = $product->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			
			
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		$model->position = Link::find()->where(['id_product' => $product->id])->max('position') + 1;
		

        return $this->render('create', [
            'model' => $model,
			'product' => $product,
        ]);
    }

    /**
     * Updates an existing Link model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$product = ProductController::findModel($model->id_product);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'product' => $product,
        ]);
    }

    /**
     * Deletes an existing Link model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$product = ProductController::findModel($model->id_product);		
		$model->delete();
        return $this->redirect(['index', 'id_product' => $product->id]);
    }

    /**
     * Finds the Link model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Link the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Link::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
