<?php
namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Request;
use app\models\RequestSearch;
//use app\code\Parser;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'activation'],
                'rules' => [
                    [
                        'actions' => ['signup', 'activation'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
					
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
/*
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                       
                    ],			*/	
					
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	public function actionRedirect($url)
    {	
		if (strpos ($url, 'http') === false)
			$url = "http://" . $url;
		header('Referrer-Policy: no-referrer');
		return $this->redirect($url);
    }
	

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {	
		//print_r(Parser::getHtml('http://quiz.khti.ru/site/info'));
		return $this->redirect(['product/index']);
        //return $this->render('index');
		
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
		{
			/*
			if (\Yii::$app->user->identity->IsUser)
			{
				return $this->goBack();				
			}
			else
			{
				return $this->goHome();
			}
			*/
			return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionActivation ($token)
	{
		$model = \app\models\User::findByActivationToken ($token);
		if (empty($model) == true)
			throw new BadRequestHttpException(Yii::t('app', 'Bad activation token'));		
		$model->removeActivationToken();
		$model->status = \app\models\User::STATUS_ACTIVE;
		if ($model->Save())
		{
			if (Yii::$app->getUser()->login($model)) 
			{
                //return $this->goHome();
				Yii::$app->session->setFlash('success', Yii::t('app', 'Activation successfully completed'));
				
            }
		}
		return $this->goHome();
	}
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) 
		{	
            if ($user = $model->signup()) 
			{
				Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));
                if (Yii::$app->getUser()->login($user)) 
				{
                    //return $this->goHome();
                }
				return $this->goHome();
            }			
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));
				

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
					