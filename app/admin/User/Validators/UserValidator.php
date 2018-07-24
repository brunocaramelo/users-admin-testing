<?php

namespace Admin\User\Validators;
use Validator;

class UserValidator{
    
    private $redirect = false;
    private $messages = false;
    
    public function __construct( $redirect = false )
    {
        $this->redirect = $redirect;
        $this->setMessages();
    }

    public function validateCreate( $fields )
    {
      return $this->make( $fields , [
                                        'email' => 'required|unique:users,email',
                                        'name' => 'required',
                                    ]);
    }

    public function validateUpdate( $fields )
    {
       return $this->make( $fields , [
                                        'email' => 'required',
                                        'name' => 'required',
                                    ]);
    }

    public function make( $fields , $rules )
    {
        $validate =  Validator::make( $fields , $rules , $this->messages );
        if($this->redirect === true)
            return $validate->validate();
        return $validate;
    }

    private function setMessages()
    {
        $this->messages = [
                            'email.required'=>'Preencha o E-mail',
                            'email.unique'=>'E-mail já esta em uso',
                            'name.required'=>'Preencha o Nome',
                            ];
    }


}