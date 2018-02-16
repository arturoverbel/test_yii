<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\FormUserRegister;
use app\models\Userm;
use yii\widgets\ActiveForm;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('index');       
        }
        return $this->redirect(['login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
     public function actionRegister(){
        
        $model = new FormUserRegister;
        $msg = "";
   
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        //Validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        //También previene por si el usuario tiene desactivado javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post())){
            
            if($model->validate()){
                //Preparamos la consulta para guardar el usuario
                $table = new Userm();
                $table->fullname = $model->fullname;
                $table->username = $model->username;
                $table->email = $model->email;
                $table->identification = $model->identification;
                $table->avatar = $model->avatar;
                
                $now = new \DateTime();
                //$table->created_at = $now;

                $table->password = md5($model->password);
                
                //clave será utilizada para activar el usuario
                $table->auth_token = $model->identification;
                //Creamos un token de acceso único para el usuario
                $table->access_token = $model->identification;

                //Si el registro es guardado correctamente
                $resultInsert = $table->save();
                if ($resultInsert){
                    
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
                    
                    $msg = "Registed!";
                }else{
                    $msg = "Ha ocurrido un error al llevar a cabo tu registro";
                }
            }
            else{
                
                $model->getErrors();
            }
        }
        
        return $this->render("register", ["model" => $model, "msg" => $msg]);
    }
    
    
}
