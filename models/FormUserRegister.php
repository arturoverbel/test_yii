<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Userm;

class FormUserRegister extends Model{
 
    public $fullname;
    public $username;
    public $email;
    public $type_id;
    public $identification;
    public $avatar;
    public $password;
    public $password_repeat;
    
    public function rules()
    {
        return [
            [['fullname', 'username', 'email', 'password', 'password_repeat'], 'required', 'message' => 'Campo requerido'],
            ['username', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Mínimo 3 y máximo 50 caracteres'],
            ['username', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Sólo se aceptan letras y números'],
            ['username', 'username_existe'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato no válido'],
            ['email', 'email_existe'],
            ['avatar', 'file'],
            ['type_id', 'string', 'max' => 5],
            ['type_id', 'identification_existe'],
            ['identification', 'string', 'max' => 20],
            ['identification', 'identification_existe'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden'],
        ];
    }
    
    public function email_existe($attribute, $params){
  
        $table = Userm::find()->where("email=:email", [":email" => $this->email]);

        if ($table->count() > 0){
            $this->addError($attribute, "El email seleccionado existe");
        }
        
    }
 
    public function username_existe($attribute, $params){
  
        $table = Userm::find()->where("username=:username", [":username" => $this->username]);
  
        if ($table->count() > 0){
            $this->addError($attribute, "El usuario seleccionado existe");
        }
  
    }
    
    public function identification_existe($attribute, $params){
  
        $table = Userm::find()
                ->where("identification=:identification", [":identification" => $this->identification])
                ->andWhere("type_id=:type_id", [":type_id" => $this->type_id]);
        
        if ($table->count() > 0){
            $this->addError($attribute, "El usuario seleccionado existe");
        }
  
    }
 
}
