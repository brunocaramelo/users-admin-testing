<?php

namespace Admin\User\Repositories;

use Illuminate\Support\Facades\Cache;


class UserCacheRepository 
{
    protected $users;

    public function __construct( UserRepository $users )
    {
        $this->users = $users;
    }

    public function getList()
    {
        return Cache::remember( 'users.list' , $minutes = 10 , function () {
            return $this->users->getList()->get();
        });
    }

  
    public function find( $id )
    {
        return Cache::remember("users.{$id}", $minutes = 60, function () use ( $id ) {
            return $this->users->find($id);
        });
    }
}