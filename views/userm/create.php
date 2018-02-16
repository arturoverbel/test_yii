<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userm */

$this->title = 'Create Userm';
$this->params['breadcrumbs'][] = ['label' => 'Userms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userm-create">
    <h2><?= $msg ?></h2>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
    'method' => 'post',
    'id' => 'formularioregister',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]);
?>
    <div class="form-group">
     <?= $form->field($model, "fullname")->input("text") ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "username")->input("text") ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "email")->input("email") ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "type_id")->radioList([
            'CC' => 'Cédula Ciudadania', 
            'CE' => 'Cédula Extranjería',
            'TI' => 'Tarjeta de Identidad',
        ]);?>   
    </div>

    <div class="form-group">
        <?= $form->field($model, "identification")->input("text") ?>   
    </div>

    <div class="form-group">
        <?= $form->field($model, "avatar")->fileInput() ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "password")->input("password") ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "password_repeat")->input("password") ?>   
    </div>

    <?= Html::submitButton("Register", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>


</div>
