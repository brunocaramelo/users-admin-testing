<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan as Artisan;

use Admin\User\Services\UserService;

class ProductTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_list_prod_default()
    {
        $expected = [  [  
                            'id' => 1,
                            'name' => 'admin',
                            'email' => 'admin@tal.com.br',
                            ]
                    ];
        $userService = new UserService();
       
        $this->assertEquals( $userService->getList()->toArray() , $expected );
    }

    public function test_update_prod()
    {
        $expected = [  'id' => '1',
                        'name' => 'admin mudei',
                        'email' => 'adminmudei@tal.com.br',
                        'excluded' => 0
                    ];
        $params =  [  'id' => '1',
                        'name' => 'admin mudei',
                        'email' => 'adminmudei@tal.com.br',
                        'excluded' => 0
                    ];
        $userService = new userService();
        $userService->update( '1' , $params );
        $final = $userService->edit( 1 )->toArray();
        
        $this->assertEquals( $final , $expected );
    }
    
    /**
     * @expectedException         \Admin\User\Exceptions\UserEditException
     * @expectedExceptionMessage Preencha o E-mail
     */
    
    public function test_update_fail_email()
    {
        $params =[  'id' => '1',
                        'name' => 'admin mudei',
                        'email' => null,
                        'excluded' => 0,
                    ];
        $userService = new userService();
        $userService->update( '1' , $params );
        $userService->edit( 1 )->toArray();
    }

    public function test_exclude_prod()
    {
        $expected =[  'id' => '1',
                        'name' => 'admin',
                        'email' => 'admin@tal.com.br',
                        'excluded' => 1
                    ];
        $userService = new userService();
        $userService->remove( 1 );
        $final = $userService->edit( 1 )->toArray();
        
        $this->assertEquals( $final , $expected );
    }

    /**
     * @expectedException         \Admin\User\Exceptions\UserEditException
     * @expectedExceptionMessage Preencha o Nome
     */
    public function test_fail_create_null_name_prod()
    {
        $expected = [   "name" => null,
                        "email" => "email@tal.com.br",
                    ];
        $userService = new userService();
        $userService->create( $expected );
        $userService->edit( 2 )->toArray();
    }

    public function test_create_prod()
    {
        $expected = [   "name" => "usuario novo",
                        "email" => "email_ta@tal.com",
                        'excluded' => "0"
                               
                    ];
        $prodService = new userService();
        $prodService->create( $expected );
        $final = $prodService->edit( 2 )->toArray();
        $expected['id'] = 2;
        $this->assertEquals( $final , $expected );
    }


    public function test_list_prod_filter_after_create()
    {
        $expected = [
                        '0' => [  'id' => 1,
                                    'name' => 'admin',
                                    'email' => 'admin@tal.com.br',
                                ],
                        '1' => [    'id' => 2,
                                    "name" => "usuario novo",
                                    "email" => "email_ta@tal.com",
                                    
                                    ]
                    ];
        $this->test_create_prod();

        $userService = new userService();
        $this->assertEquals( $userService->getList()->toArray() , $expected );
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
