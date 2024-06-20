<?php

namespace app\controllers;

use Yii;
use app\models\ParserRule;
use app\models\ParserRuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\UserException;

use app\code\Parser;



/**
 * ParserRuleController implements the CRUD actions for ParserRule model.
 */
class ParserRuleController extends Controller
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
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'test'],
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
	
	public function actionTest ($id = 0) 
	{			
		try
		{
			$loaded = false;
			if (!empty($id))
			{
				$model = $this->findModel($id);
				$loaded = true;
			}
			else
			{
				$model = new ParserRule();
				$loaded = $model->load(Yii::$app->request->post());
			}
			
			if ($loaded) 
			{	
				$html = Parser::getHtml($model->test_url);				
				if (empty ($html))
					throw new UserException(Yii::t('app', 'Html not loaded'));								
				return Parser::getText ($html, $model->selector);				
			}
		}
		catch (UserException $e) 
		{
			return Yii::t('app', 'Error: {errorMessage}', ['errorMessage' => $e->getMessage()]) ;
		}
	}
	
    /**
     * Lists all ParserRule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParserRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->orderby(['url' => SORT_ASC]);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParserRule model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ParserRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ParserRule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ParserRule model.
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
     * Deletes an existing ParserRule model.
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
     * Finds the ParserRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParserRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = ParserRule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
