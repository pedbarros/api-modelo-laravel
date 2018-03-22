<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{

    use Notifiable;

    // tabela que essa classe se referencia
    protected $table = 'gp_user';
    protected $primaryKey = "GP_COD_USER";
    protected $username = 'GP_USUARIO';

    // não colocar campos de alteração de informações
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // atributo a qual vou inserir informações
    protected $fillable = [
        'GP_USUARIO', 'GP_PASSWORD'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'GP_PASSWORD',
    ];


    /**
     * Get the password for the user.
     * Atribuindo o valor do password para o atributo que significa a senha na tabela
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this -> GP_PASSWORD;
        //return Hash::make($this -> GP_PASSWORD);
    }

    /**
     * Overrides the method to ignore the remember token.
     * Removendo a obrigatoriedade da tabela de autenticação ter o atributo "remenber_token"
     */
    public function setAttribute($key, $value) {
        $isRememberTokenAttribute = $key == $this -> getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }
}
