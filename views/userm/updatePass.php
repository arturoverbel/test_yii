<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userm */

$this->title = 'Update Userm: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Userms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userm-update">

    <?php $form = ActiveForm::begin(); ?>
 
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
 
        <div class="form-group">
            <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>