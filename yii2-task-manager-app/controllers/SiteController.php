<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;


/**
 * SiteController implementa as ações padrão do site como login, logout, etc.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    // Define os comportamentos do controlador
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    // Define ações padrão para erros e CAPTCHA.
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

    /**
     * {@inheritdoc}
     */
    // Verifica se o utilizador está autenticado antes de executar qualquer ação.
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest || $action->id === 'login' || $action->id === 'signup') {
            return parent::beforeAction($action);
        } else {
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Exibe a página inicial.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Exibe o formulário de contacto.
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Exibe a página "About".
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    // Ação para signup de utilizador.
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Ação para login de utilizador.
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['task/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Ação para logout de utilizador.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}
