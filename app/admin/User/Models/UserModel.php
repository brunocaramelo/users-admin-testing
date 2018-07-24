<?php

namespace Admin\User\Models;

use Admin\User\Validators\UserValidator;
use Admin\User\Exceptions\UserEditException;
use Admin\User\Entities\UserEntity;
use Admin\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
 

class UserModel
{
    private $prodRepo = null;
    
    public function __construct()
    {
        $this->prodRepo = new UserRepository( new UserEntity() );
    }

    public function getList()
    {
        return $this->prodRepo->getList( )->get();
    }

    public function remove( $identify )
    {
        return $this->prodRepo->remove( $identify );
    }

    public function create( array $data )
    {
        $data['password'] = ( empty( $data['password'] ) ? Hash::make(str_random(15) ) : $data['password'] );
        $data['api_token'] =  Hash::make(str_random(20) );
        
        $validate = new UserValidator();
        $validation = $validate->validateCreate( $data );
        if( $validation->fails() )
            throw new UserEditException( implode( "\n" , $validation->errors()->all() ) );
        return $this->prodRepo->create( $data );
    }

    public function update( $identify , array $data )
    {
        $validate = new UserValidator();
        $validation = $validate->validateUpdate( $data );
        if( $validation->fails() )
            throw new UserEditException( implode( "\n" , $validation->errors()->all() ) );
        return $this->prodRepo->update( $identify , $data );
    }

    public function edit( $identify )
    {
        $edit = $this->find( $identify );
        unset( $edit['created_at'], $edit['updated_at'] , $edit['api_token'] );
        return $edit;
    }

    public function find( $identify )
    {
        return $this->prodRepo->find( $identify );
    }

    public function findByCode( $value )
    {
        return $this->findBy( 'code' , $value );
    }

    public function findBy( $field , $value )
    {
        return $this->prodRepo->findBy( $field , $value )->first();
    }

}