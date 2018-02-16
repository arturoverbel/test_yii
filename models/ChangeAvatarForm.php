<?php
namespace app\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Change password form for current user only
 */
class ChangeAvatarForm extends Model
{
    public $id;
    public $avatar;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_user = Userm::find()
                ->where("id=:id", [":id" => $id])
                ->one();

        if (!$this->_user) {
            throw new InvalidParamException('Unable to find user!');
        }
        
        $this->id = $this->_user->id;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['avatar', 'file'],
        ];
    }

}