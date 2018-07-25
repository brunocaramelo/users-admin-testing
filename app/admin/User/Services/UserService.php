<?php

namespace Admin\User\Services;

use Admin\User\Models\UserModel;

class UserService
{
    private $userModel = null;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getList()
    {
        return $this->userModel->getList();
    }

    public function remove( $identify )
    {
        return $this->userModel->remove( $identify );
    }

    public function create( array $data )
    {
        return $this->userModel->create( $data );
    }

    public function update( $identify , array $data )
    {
        return $this->userModel->update( $identify , $data );
    }

    public function edit( $identify )
    {
        return $this->userModel->edit( $identify );
    }

    public function find( $identify )
    {
        return $this->userModel->find( $identify );
    }

    public function findByCode( $value )
    {
        return $this->findByCode( $value );
    }

}