<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userm */

$this->title = 'Update Userm: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Userms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
