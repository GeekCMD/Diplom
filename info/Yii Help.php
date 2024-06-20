
************************************************************************************************************************
Необходимые компоненты
************************************************************************************************************************
C:\WEB\Sites\htdocs\basic

"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require 2amigos/yii2-gallery-widget:~1.0
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require "2amigos/yii2-google-maps-library" "*"
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require --prefer-dist miloschuman/yii2-highcharts-widget "*"
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require kartik-v/yii2-grid "@dev"
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require kartik-v/yii2-widgets "*"
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require kartik-v/yii2-tabs-x "@dev"
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require philippfrenzel/yii2fullcalendar "*"
"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar update yiisoft/yii2 yiisoft/yii2-composer bower-asset/jquery.inputmask



"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require --prefer-dist raoul2000/yii2-bootswatch-asset "*"


************************************************************************************************************************
Стилизаия bootstrap
************************************************************************************************************************
https://github.com/raoul2000/yii2-bootswatch-asset
https://bootswatch.com/flatly/


"C:\WEB\PHP\PHP 7.2.5\php.exe" C:\composer\composer.phar require --prefer-dist raoul2000/yii2-bootswatch-asset "*"

************************************************************************************************************************
Стилизация грида (стилизуем строки и ячейки)
************************************************************************************************************************

<?php
	// http://nix-tips.ru/yii2-razbiraemsya-s-gridview.html
?>	

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'rowOptions' => function($model, $key, $index)
                    {						
                        return ['style' => ['background'=>'green']];
                    },					
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'id',			
				'contentOptions' => function($model)
                    {						
                        return ['style' => ['background'=>'black']];
                    }
			],
		]
	])
?>


************************************************************************************************************************
Класс пользовательских исключений
************************************************************************************************************************
<?
	use yii\base\UserException;	
?>
************************************************************************************************************************
Классыне диаграммы в Yii2
************************************************************************************************************************
<?php
	//
	// http://www.yiiframework.com/extension/yii2-highcharts-widget
	// php composer.phar require --prefer-dist miloschuman/yii2-highcharts-widget "*"
	//
	
	use miloschuman\highcharts\Highcharts;

	
	
				$data = $dataProvider->allModels;
				
				$categories = [];
				$created = [];
				$closed = [];
				$processing = [];
				
				for ($i = 0; $i < count ($data); $i ++)
				{
					$categories[] = \Yii::$app->formatter->asDate($data[$i]['date']);
					$created[] = $data[$i]['created'] + 0;
					$closed[] = $data[$i]['closed'] + 0;
					$processing[] = $data[$i]['processing'] + 0;					
				}
				
				echo Highcharts::widget([
					'options' => [
						'title' => ['text' => Yii::t('app', 'Common Report')],
						'xAxis' => [
							'categories' => $categories
						],
						'yAxis' => [
							'title' => ['text' => 'Количество заявок']
						],
						'series' => [
							['name' => 'Создано', 'data' => $created],
							['name' => 'Закрыто', 'data' => $closed],
							['name' => 'В работе', 'data' => $processing],
						], 
					]
				]);
			?>
			


************************************************************************************************************************
Данные для GridView (из массива и из базы)
************************************************************************************************************************
<?php
		$data = [];		
		for ($i = 0; true; $i ++)
		{			
			$record = [];
			$date = strtotime($date1 . ' +' . $i . ' day');						
			if ($date > strtotime($date2))
				break;			
			$record['date'] = $date;
			$record['created'] = $this->RequestCountСreated($date);
			$record['closed'] = $this->RequestCountClosed($date);
			$record['processing'] = $this->RequestCountProcessing($date);
			$data[] = $record;			
		}				

		$dataProvider = new ArrayDataProvider([
			'allModels' => $data,
			'sort' => [
				'attributes' => ['date', 'created', 'closed', 'processing'],
			],
			'pagination' => [
				'pageSize' => 20,
			],
		]);		
		
        return $this->render('common', [
            'dataProvider' => $dataProvider,
			'Settings' => $Settings,
        ]);				
?>

<?php
		use yii\data\ActiveDataProvider;
		$dataProvider = new ActiveDataProvider([
            'query' => $Q
			,
        ]);
		
		return $this->render('common', [
            'dataProvider' => $dataProvider,
			'Settings' => $Settings,
        ]);	
?>

************************************************************************************************************************
Форматирование в Yii2
************************************************************************************************************************

<?php

	\Yii::$app->formatter->format($model->description, 'ntext');
	
	\Yii::$app->formatter->asDate($dateStr, $fmt);
	
	date('Y-m-d H:i:s');
	

?>

************************************************************************************************************************
Лукапы для форм редактирования
************************************************************************************************************************
<?php 
use yii\helpers\ArrayHelper;
<?= $form->field($model, '')->dropDownList(yii\helpers\ArrayHelper::map(app\models\TranspotType::find()->orderby(['title'=>SORT_ASC])->all(), 'id', 'title')) ?>
<?= $form->field($model, '')->dropDownList(yii\helpers\ArrayHelper::map(app\models\TranspotType::find()->orderby(['title'=>SORT_ASC])->all(), 'id', 'title'), ['prompt'=>Yii::t('app','Not selected')]) ?>
?>
************************************************************************************************************************
Форма для фильтрации открывается при нажатии на кнопку
************************************************************************************************************************
<?php 
	if (empty($_GET['filter']) == false)
		echo $this->render('_search', ['model' => $searchModel]); 
?>
<?php 
	if (empty($_GET['filter']) == false)
	{
		echo Html::a(Yii::t('app', 'Hide filter'), ['index', 'filter'=>'0'], ['class' => 'btn btn-default']); 
	}
	else
	{
		echo Html::a(Yii::t('app', 'Show filter'), ['index', 'filter'=>'1'], ['class' => 'btn btn-success']);
	}			
?>	
<input type="hidden" name="filter" value="1">
************************************************************************************************************************
Индекс с поиском
************************************************************************************************************************
<?php 
		 public function actionIndex()
    {
		Yii::$app->user->identity->accessAdminOnly;		
		
        $searchModel = new SysUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

?>

<?php 
	echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
			//'status',
			'user_type',
			'username',
            'user_status',            
			'email:email',   
			'last_name',
			'first_name',
			'middle_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
?>
************************************************************************************************************************
Добавление дополнительного свойства к модели (используя связь, геттер)
************************************************************************************************************************
<?php 
	public function getSum()
	{
		//
                
		$Data = $this->idService;
		if (isset ($Data))
		{
			return $Data->cost * $this->amount;			
		}
	
	}
?>	
************************************************************************************************************************
Добавление к модели возможности загрузки изображений
************************************************************************************************************************
<?php 	
	public $image;	
	public function getOriginal_image_url ()
	{
		//
		if ((empty ($this->id) == false))
		{
			//			
			return Yii::$app->params['imageDir'] . 'Request/original/' . $this->id;
		}
	}	
	public function getImage_url ()
	{
		//
		if ((empty ($this->id) == false))
		{
			//
			//return $this->getThumbFileUrl('image', 'thumb');						
			return Yii::$app->params['imageDir'] . 'Request/thumb/' . $this->id;
		}
	}	
	public function behaviors()
	{
		return 
		[
			[
             'class' => '\yiidreamteam\upload\ImageUploadBehavior',
             'attribute' => 'image',			
             'thumbs' => ['thumb' => ['width' => 100, 'height' => 100], ],			 
             'filePath' => Yii::$app->params['imagePath'] . '[[model]]/original/[[pk]]',
             'fileUrl' => Yii::$app->params['imageDir'] . '[[model]]/original/[[pk]]',			 
             'thumbPath' => Yii::$app->params['imagePath'] . '[[model]]/thumb/[[pk]]',
             'thumbUrl' => Yii::$app->params['imageDir'] . '[[model]]/thumb/[[pk]]',			 
			]		
		];
	}
?>	
	
<?php
	use kartik\widgets\FileInput;
?> 

	<?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
	
	<?= $form->field($model, 'image')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']
]]); ?> 
	<?php 
		if (empty ($model->original_image_url) == false)
			echo Html::img ($model->original_image_url, ['width'=>'100%']); 
		
	?>	
    <?= '<br><br>' ?>     

<?php
	public function attributeLabels()
    {
        return [
			'original_image_url:image',	
			'image' => Yii::t('app', 'Фото'),
			'original_image_url' => Yii::t('app', 'Фото'),
			'image_url' => Yii::t('app', 'Фото'),
		];
	}
?> 

************************************************************************************************************************
Создание ссылки (по всем правилам)
************************************************************************************************************************
<?php			
	Yii::$app->urlManager->createUrl (['movie/evaluate']);
?> 
************************************************************************************************************************
Отправить пользователя не реферрер
************************************************************************************************************************
<?php

		$Referrer = Yii::$app->getRequest()->getReferrer();	
		if (isset ($Referrer))
		{
			$this->redirect($Referrer);
		}
		else
		{
			//
			$this->goHome();
		}
?> 
************************************************************************************************************************
Автоформатирование кода в NetBeanse
************************************************************************************************************************
<?php
	'NetBeanse автоформатирование кода Alt + Shift + f'
?> 
************************************************************************************************************************
Настройка доступа к методам контроллеров 
************************************************************************************************************************
<?php
	use yii\filters\AccessControl;	
	public function behaviors()
    {	
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
			
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
					'actions' => ['index', 'view', 'create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['@'],
					],
				],
			],				
			
        ];
    }
	
?> 
************************************************************************************************************************
Правильный контроль доступа к методам контроллера
************************************************************************************************************************
<?

	use yii\filters\AccessControl;	

	public function behaviors()
    {	
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => 
				[	
					[
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function ($rule, $action) 
						{
							return Yii::$app->user->identity->IsAdmin || Yii::$app->user->identity->IsExpert;
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
?> 

************************************************************************************************************************
Правильный лукап в DetailView
************************************************************************************************************************


	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loading_date',
			
            [
				'attribute' => 'id_content_type',	
				'value' => empty ($model->idContentType) == false ? $model->idContentType->title : null,
			],   
			
            [
				'attribute' => 'id_content_state',								
				'value' => empty ($model->idContentState) == false ? $model->idContentState->title : null,
			],   
		
            'title',
            'description:ntext',
            'html_code:ntext',
            'public_code',
			
            [				
				'attribute' => 'id_user',						
				'value' => empty ($model->idUser) == false ? $model->idUser->username : null,
			],                        
			[
				'attribute' => 'id_image',		
				'format' => 'raw',
				'value' => empty ($model->ImageFullName) == false ? Html::img ($model->ImageFullName) : null,
			],   
        ],
    ]) ?>

************************************************************************************************************************
Правильный лукап в GridView
************************************************************************************************************************
	
use yii\helpers\ArrayHelper;

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'attribute' => 'id',
				'options' => ['width' => '100'],
			],  
			[
				'attribute' => 'loading_date',
				//'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
				'options' => ['width' => '200'],
			],
			[
				'attribute' => 'id_content_type',				
				'filter' => ArrayHelper::map(app\models\ContentType::find()->orderby(['title'=>SORT_ASC])->all(), 'id', 'title'),
				'content' => function($data)
				{
					$var = $data->idContentType;
					if (empty($var) == false)
						return $var->title;
					return '';
				},
			
			],   
			[
				'attribute' => 'id_content_state',				
				'filter' => ArrayHelper::map(app\models\ContentState::find()->orderby(['title'=>SORT_ASC])->all(), 'id', 'title'),
				'content' => function($data)
				{
					$var = $data->idContentState;
					if (empty($var) == false)
						return $var->title;
					return '';
				},
			],                 
            'title',
            [
				'attribute' => 'id_user',				
				'filter' => \yii\helpers\ArrayHelper::map(app\models\User::find()->orderby(['last_name'=>SORT_ASC, 'first_name'=>SORT_ASC, 'middle_name'=>SORT_ASC])->all(), 'id', 'title'),
				'content' => function($data)
				{
					$var = $data->user;
					if (empty($var) == false)
						return $var->title;
					return null;
				},
			],                 
			
			[
				'label' => Yii::t('app', 'Image'),
				'format' => 'raw',
				'value' => function($data)
				{
					return Html::img($data->ImageFullName, ['style' => 'width:150px;']);
				},
			],

            [
				'class' => 'yii\grid\ActionColumn', 
				'template' => '{documents} {view} {update} {delete}',
				'buttons' =>
					[
						'documents'=>  function ($url, $model, $key)
						{							
							return Html::a('<span class="glyphicon glyphicon-tasks"></span>', ['document/index', 'id_folder' => $model->id], ['title' => Yii::t('app', 'Documents'), 'target'=>'_blank']);
						}
					],	
				'options' => ['width' => '85'],
			 
			
			],
			
        ],
    ]); ?>
	

************************************************************************************************************************
Добавить свои управляющие кнопки в Grid
************************************************************************************************************************
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'model',

            ['class' => 'yii\grid\ActionColumn', 
			 'template' => '{view} {update} {delete} {kitset}',
			 'buttons'=>
				[
				'kitset'=>  function ($url, $model, $key)
					{
						$url=Yii::$app->getUrlManager()->createUrl(['kit-element/index','id_kit'=>$model['id']]);
						return Html::a(/*'<span class="glyphicon glyphicon glyphicon-pencil"></span>'*/ 'Состав', $url, ['title' => Yii::t('yii', 'View'), 'data-pjax' => '0',]);
					}
				],							
			
			],
        ],
    ]); 
?>
************************************************************************************************************************
Разрешить доступ только администратору
************************************************************************************************************************
<?php
		if (Yii::$app->user->identity->isAdmin == false)
		{
			throw new \Exception (Yii::t('app', 'For admin only'));
		}
		$Results = Yii::$app->db->createCommand($Query->body, [':param_id_sys_user' => $id_user])->queryAll();       			
?>



************************************************************************************************************************
Обращение к базе данных через текущее соединение (настроенное через конфиг)
************************************************************************************************************************
<?php
	$Results = Yii::$app->db->createCommand($Query->body, [':param_id_sys_user' => $id_user])->queryAll();       			
?>
************************************************************************************************************************
Использование TabX
************************************************************************************************************************
<?php
	use kartik\tabs\TabsX;
	$tabs[] = [
		'label' => $mark->title,
		'content' => TabsX::widget([
			'position' => TabsX::POS_ABOVE,
			'align' => TabsX::ALIGN_LEFT,			
			'items' => $sub_tabs,
			'bordered' => true,
		]),						
	];
	echo TabsX::widget([
				'position' => TabsX::POS_ABOVE,
				'align' => TabsX::ALIGN_LEFT,			
				'items' => $tabs,
				'bordered' => true,
				]);						
?>
************************************************************************************************************************
Создание вывода с правилами
************************************************************************************************************************
<?php				
	public function actionRequestJournal()
    {	
		Yii::$app->user->identity->AccessAdminManager;
		
		
		$User = User::find()->where (['id'=> Yii::$app->user->identity->id])->one();				
		
        $dataProvider = new ActiveDataProvider([
            'query' => Request::find()->where ('date_reg >= :date1 and date_reg < :date2', [':date1'=>$User->report_date_1, ':date2'=>$User->report_date_2])
			->andFilterWhere(['id_user'=>$User->report_id_user, 'id_defect'=>$User->report_id_defect, 'id_client'=>$User->report_id_client])
			,
        ]);
        return $this->render('report-request-journal', [
            'dataProvider' => $dataProvider,
			'ReportParams' => User::findOne(Yii::$app->user->identity->id),
        ]);
    }  
?>
************************************************************************************************************************
Составление запроса в Yii
************************************************************************************************************************
<?php

	use yii\data\ActiveDataProvider;

	public function actionServicesStat()
    {	
	
		Yii::$app->user->identity->AccessAdminManager;
		
		$User = User::find()->where (['id'=> Yii::$app->user->identity->id])->one();				
		
		$Q = new Yii\db\Query ();
		
		$Q->select([
				'service.id',
				'service.title',
				'service.cost',	
				'sum(request_service.amount) as service_count',
				'sum(request_service.amount)*service.cost as service_total',
				
			])->		
		from(['service', 'request_service', 'request'])->		
		
		andWhere ('service.id = request_service.id_service')->
		andWhere ('request.id = request_service.id_request')->		
		andWhere ('request.date_reg >= :date1 and request.date_reg < :date2')->
		groupby (['service.id', 'service.title', 'service.cost'])->
		orderby('service.title')->		
		params ([':date1'=>$User->report_date_1, ':date2'=>$User->report_date_2])
		;		
		
        $dataProvider = new ActiveDataProvider([
            'query' => $Q
			,
        ]);

        return $this->render('report-services-stat', [
            'dataProvider' => $dataProvider,
			'ReportParams' => User::findOne(Yii::$app->user->identity->id),
        ]);
    } 
	
?>
************************************************************************************************************************
Автодополняемое поле (Typeahead)
************************************************************************************************************************
<?php

			echo $form->field($model, 'recipient_city')->widget(kartik\widgets\TypeaheadBasic::classname(), [		
			'options' => ['placeholder' => 'Название города'],
			'pluginOptions' => [
				'allowClear' => true,
				'minLength'=>2,
			],
			'data' => ArrayHelper::map(app\models\RbCity::find()->orderby(['title'=>'title asc'])->all(), 'title', 'title'),			
		]); 

?>

************************************************************************************************************************
Отдать файл пользователю
************************************************************************************************************************
public function actionDownload ($id)
	{
		$model = $this->findModel($id);
		$storagePath = Yii::getAlias(Yii::$app->params['ContentDirectory']);
		$filename = $model->id . '.data';
		if (!is_file("$storagePath/$filename")) {
			throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The file does not exists.'));		
		}
		return Yii::$app->response->sendFile("$storagePath/$filename", $model->file_name);				
	}
************************************************************************************************************************
Валидаторы
************************************************************************************************************************
https://p0vidl0.info/yii2-api-guides/guide-ru-tutorial-core-validators.html#unique

************************************************************************************************************************
Разбор URL
************************************************************************************************************************
// Кроме PHP_URL_HOST доступны еще PHP_URL_SCHEME, PHP_URL_PORT, PHP_URL_USER, PHP_URL_PASS, PHP_URL_PATH, PHP_URL_QUERY и PHP_URL_FRAGMENT.	
	echo 'PHP_URL_HOST: ' . parse_url($url, PHP_URL_HOST) . '<br>';
	echo 'PHP_URL_SCHEME: ' . parse_url($url, PHP_URL_SCHEME) . '<br>';
	echo 'PHP_URL_PORT: ' . parse_url($url, PHP_URL_PORT) . '<br>';
	echo 'PHP_URL_USER: ' . parse_url($url, PHP_URL_USER) . '<br>';
	echo 'PHP_URL_PASS: ' . parse_url($url, PHP_URL_PASS) . '<br>';
	echo 'PHP_URL_PATH: ' . parse_url($url, PHP_URL_PATH) . '<br>';
	echo 'PHP_URL_QUERY: ' . parse_url($url, PHP_URL_QUERY) . '<br>';
	echo 'PHP_URL_FRAGMENT: ' . parse_url($url, PHP_URL_FRAGMENT) . '<br>';
************************************************************************************************************************
Корень проекта
************************************************************************************************************************	
		
Yii::$app->getBasePath() 

************************************************************************************************************************
Url проекта
************************************************************************************************************************	

use yii\helpers\Url;

Url::base();         // /myapp
Url::base(true);     // http(s)://example.com/myapp - depending on current schema
Url::base('https');  // https://example.com/myapp
Url::base('http');   // http://example.com/myapp
Url::base('');       // //example.com/myapp

************************************************************************************************************************
Ajax + Yii2
************************************************************************************************************************	

<script>
    function ruleTest() {
        var retVal = confirm("Проверить правило?");
        if (retVal == true) {
            $.ajax(
                {
                    type: "POST",
                    url: "<?= Yii::$app->urlManager->createUrl (['parser-rule/test', 'id' => $model->id]); ?>",
                    //data: { id: <?= $model->id ?>},
                    success: function (result) {
                        if (result.Error) {
							alert(result.Error);
                        }
                        else 
						{                                
                            alert(result);
                        }
                    }
                });

            return true;
        } else {
            return false;
        }
    }
</script>
************************************************************************************************************************
Ajax + Yii2 (сериализация данных формы)
************************************************************************************************************************	
<script>


    function ruleTest() {
        //var retVal = confirm("Проверить правило?");
        //if (retVal == true) 
		{
            $.ajax(
                {
                    type: "POST",
                    url: "<?= Yii::$app->urlManager->createUrl (['parser-rule/test']); ?>",
                    data: $(parserRuleForm).serialize(),
                    success: function (result) {
                        if (result.Error) 
						{
							alert(result.Error);
                        }
						else 
						{                                
                            alert(result);
                        }
                    }
                });

            return true;
        } 
		//else {return false;}
    }
</script>

************************************************************************************************************************
Обработчики событий модели
************************************************************************************************************************	

	public function afterSave($insert, $changedAttributes){
		
		parent::afterSave($insert, $changedAttributes);	
		
		$product = $this->product;
		if (!empty($product)) {
			$product_links = $product->links;	
			if ($this->main_link) {						
				foreach ($product_links as $product_link) {
					if ($product_link->main_link && $product_link->id != $this->id) {
						$product_link->main_link = false;
						$product_link->save();
					}
				}
			} 		
			else
			{
				if (count($product_links) == 1 && !$this->main_link) {								
					$this->main_link = true;
					$this->save();					
				}
			}			
		}
	}
	
	public function beforeDelete()
	{        
		if ($this->main_link) {
			$product = $this->product;
			if (!empty($product)) {			
				$link = Link::find()->andWhere(['id_product' => $product->id])->andWhere(['<>','id', $this->id])->orderby(['position' => SORT_ASC])->one();
				if (!empty($link)) {
					$link->SetupAsMainLink ();
				}	
			}		
		}
		return parent::beforeDelete();
	}
