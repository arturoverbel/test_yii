<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userm-view">

    <h1>Usuarios</h1>

    <p>
        <?php /* Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    
    <div class="container">
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'fullname',
                        [    
                            'attribute' => 'image',
                            'format' => 'html',    
                            'value' => function ($data) {
                                return Html::img($data['avatar'],
                                    ['width' => '100px', 'height' => '100px']);
                            },
                        ],
                        'username',
                        'email:email',
                        'type_id',
                        'identification',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
