<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userModel".
 *
 * @property int $id
 * @property string $fullname
 * @property string $username
 * @property string $email
 * @property string $type_id
 * @property string $identification
 * @property string $avatar
 * @property string $password
 * @property string $auth_token
 * @property string $access_token
 * @property string $last_login
 * @property string $created_at
 * @property string $updated_at
 */
class Userm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(){
        return 'userModel';
    }
    
    public static function getDb(){
        return Yii::$app->db;
    }

    
}
