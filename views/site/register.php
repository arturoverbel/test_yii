<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h3><?= $msg ?></h3>

<h1>Register</h1>
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
     <?= $form->field($model, "type_id")->input("text") ?>   
    </div>

    <div class="form-group">
        <?= $form->field($model, "identification")->input("text") ?>   
    </div>

    <div class="form-group">
        <?= $form->field($model, "avatar")->input("text") ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "password")->input("password") ?>   
    </div>

    <div class="form-group">
     <?= $form->field($model, "password_repeat")->input("password") ?>   
    </div>

    <?= Html::submitButton("Register", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>

