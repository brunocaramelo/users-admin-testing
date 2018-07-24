<?php

namespace Admin\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Admin\User\Services\UserService;
use Admin\User\Exceptions\UserEditException;

class UserController extends Controller
{
    public function __construct()
    {
    }
  
    public function listAll()
    {
        $service = new UserService();
        return response()->json( $service->getList() );
    }
    
    public function findById( Request $request )
    {
        $service = new UserService();
        return response()->json( $service->edit( $request->id ) );
    }

    public function update( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new UserService();
            $service->update( $request->id , $request->all() );
            \DB::commit();
            $return['message'] = 'Usuario editado com sucesso';
            return response()->json( $return );
        }catch( UserEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }
    
    public function remove( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new UserService();
            $service->remove( $request->id );
            \DB::commit();
            $return['message'] = 'Usuario excluido com sucesso';
            return response()->json( $return );
        }catch( UserEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }

    public function create( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new UserService();
            $service->create( $request->all() );
            $return['message'] = 'Usuario criado com sucesso';
            \DB::commit();
            return response()->json( $return );
        }catch( UserEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }
}
