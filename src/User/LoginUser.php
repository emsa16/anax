<?php
namespace Emsa\User;

use \LRC\Common\BaseModel;
use \LRC\Common\ValidationTrait;
use \LRC\Common\ValidationInterface;

class LoginUser extends BaseModel implements ValidationInterface
{
    use ValidationTrait;



    public $id;
    public $username;
    public $password;



    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->setValidation([
            'username' => [
                [
                    'rule' => 'required',
                    'message' => 'Användarnamn måste anges.'
                ],
                [
                    'rule' => 'forbidden-characters',
                    'value' => '&<>\"\'',
                    'message' => 'Otillåtna tecken använda. Följande tecken är icke tillåtna: & < > \' "'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 50,
                    'message' => 'Användarnamnet får vara maximalt 50 tecken långt.'
                ],
            ],
            'password' => [
                [
                    'rule' => 'required',
                    'message' => 'Lösenord måste anges.'
                ],
                [
                    'rule' => 'forbidden-characters',
                    'value' => '&<>\"\'',
                    'message' => 'Otillåtna tecken använda. Följande tecken är icke tillåtna: & < > \' "'
                ],
            ],
        ]);
    }
}
