<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userms';
$this->params['breadcrumbs'][] = "Usuarios";
?>
<div class="userm-index">

    <h1>Usuarios</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Userm', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [    
                'attribute' => 'image',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data['avatar'],
                        ['width' => '40px', 'height' => '40px']);
                },
            ],
            'fullname',
            'username',
            'email:email',
            [
                'label' => 'ID',
                'value' => function ($data) {
                    return $data->type_id . " " . $data->identification;
                },
            ],
            //'avatar',
            //'password',
            //'auth_token',
            //'access_token',
            //'last_login',
            //'created_at',
            //'updated_at',
                        
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {change} {delete}',
                'buttons'  => [
                    'change' => function($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
                                    'title' => Yii::t('app', 'Change Avatar'),]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                            $url = 'index.php?r=userm/view&id='.$model['id'].'';
                            return $url;
                    }
                    if ($action === 'update') {
                            $url = 'index.php?r=userm/changepassword&id='.$model['id'].'';
                            return $url;
                    }
                    if ($action === 'change') {
                            $url = 'index.php?r=userm/changeavatar&id='.$model['id'].'';
                            return $url;
                    }
                    if ($action === 'delete') {
                            $url = 'index.php?r=userm/delete&id='.$model['id'].'';
                            return $url;
                    }
                }


            ],
        ],
    ]); ?>
</div>
