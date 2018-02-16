<?php

namespace app\controllers;

use Yii;
use app\models\Userm;
use app\models\UsermSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\FormUserRegister;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\FormUpload;
use yii\web\UploadedFile;
use app\models\ChangePasswordForm;
use app\models\ChangeAvatarForm;

/**
 * UsermController implements the CRUD actions for Userm model.
 */
class UsermController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Userm models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $searchModel = new UsermSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Userm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $model = new FormUserRegister;
        $msg = "";
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())){
            
            if($model->validate()){
                //Preparamos la consulta para guardar el usuario
                $table = new Userm();
                $table->fullname = $model->fullname;
                $table->username = $model->username;
                $table->type_id = $model->type_id;
                $table->email = $model->email;
                $table->identification = $model->identification;
                //$table->avatar = $model->avatar;
                
                $model->avatar=UploadedFile::getInstance($model,'avatar');
                $nameFile = 'avatars/' . $model->avatar->baseName . '.' . $model->avatar->extension;
                
                $table->password = md5($model->password);
                $table->avatar = $nameFile;
                $table->auth_token = $model->identification;
                $table->access_token = $model->identification;
                
                if ( $table->save() ){
                    
                    $model->avatar->saveAs($nameFile);
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
                    
                    return $this->redirect(['view', 'id' => $table->id]);
                }else{
                    $msg = "Ha ocurrido un error al llevar a cabo tu registro";
                }
            }
            else{
                $model->getErrors();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'msg' => $msg,
        ]);
    }

    /**
     * Updates an existing Userm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Userm model.
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
     * Finds the Userm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
        /**
     * Change User password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChangepassword($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        try {
            $model = new ChangePasswordForm($id);
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
     
        if ($model->load(\Yii::$app->request->post()) && $model->validate() ) {
            
            $table = Userm::find()
                ->where("id=:id", [":id" => $id])
                ->one();
        
            $table->password = md5($model->password);
            if ( $table->save() ){
                return $this->redirect(['view', 'id' => $table->id]);
            }else{
                $msg = "Ha ocurrido un error al llevar a cabo tu registro";
            }
            
            \Yii::$app->session->setFlash('success', 'Password Changed!');
        }
     
        return $this->render('updatePass', [
            'model' => $model,
        ]);
    }
    
        /**
     * Change User password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChangeavatar($id)
    {
        
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        try {
            $model = new ChangeAvatarForm($id);
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
     
        if ($model->load(\Yii::$app->request->post()) && $model->validate() ) {
            
            $table = Userm::find()
                ->where("id=:id", [":id" => $id])
                ->one();
        
            $model->avatar=UploadedFile::getInstance($model,'avatar');
            $nameFile = 'avatars/' . $model->avatar->baseName . '.' . $model->avatar->extension;
            $table->avatar = $nameFile;    
            
            if ( $table->save() ){
                
                $model->avatar->saveAs($nameFile);
                
                return $this->redirect(['view', 'id' => $table->id]);
            }else{
                $msg = "Ha ocurrido un error al llevar a cabo tu registro";
            }
            
            \Yii::$app->session->setFlash('success', 'Password Changed!');
        }
     
        return $this->render('changeavatar', [
            'model' => $model,
        ]);
    }
    
}
