<?php 

namespace Admin\User\Repositories;

use Admin\User\Entities\UserEntity;

class UserRepository
{
    private $car = null;

    public function __construct( UserEntity $user )
    {
        $this->user = $user;
    }

    public function getList()
    {
        $query = $this->user->select(
                                'us.id as id',
                                'us.name as name',
                                'us.email as email'
                                )
                            ->from('users AS us')
                            ->where( 'us.excluded' , '=' , '0' );
        return $query;
    }

    public function find( $identify )
    {
        return $this->user->find( $identify );
    }

    public function findBy( $field , $value )
    {
        return $this->user->where( $field , $value );
    }
    
    public function remove( $identify )
    {
        $userSave = $this->user->find($identify);
        return $userSave->fill( [ 'excluded' => '1' ] )->save();
        
    }
    
    public function create( $data )
    {
        return $this->user->create( $data );
    }

    public function update( $identify , $data )
    {
        $userSave = $this->user->find($identify);
        return $userSave->fill( $data )->save();
    }

}