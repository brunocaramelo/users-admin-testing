<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Artisan as Artisan;


class usersApiTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_fail_update_item()
    {   
        $this->put('/api/v1/user/1',[     
                                            "name" => null,
                                            "email" => "email@tal.com",
                                    ])
                ->assertStatus(400)
                ->assertJson([
                                'message' => "Preencha o Nome" 
                            ]);
    }

    public function test_fail_create_item()
    {   
        $this->put('/api/v1/user/1',[     
                                            "name" => 'mudando nome',
                                            "email" => null,
                                    ])
                ->assertStatus(400)
                ->assertJson([
                                'message' => "Preencha o E-mail" 
                            ]);
    }
    
    public function test_update_item()
    {   
        $this->put('/api/v1/user/1',[     
                                                "id" => "1",
                                                "email" => "emailmudei@tal.com",
                                                "name" => "name di admin",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Usuario editado com sucesso' 
                            ]);
    }
    public function test_create_item()
    {   
        $this->post('/api/v1/user/',[     
                                    "email" => "novoemail@tal.com",
                                    "name" => "novo usuario",
                                    ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Usuario criado com sucesso' 
                            ]);
    }

    public function test_remove_item()
    {   
        $this->delete('/api/v1/user/1',[     
                                                "id" => "1",
                                        ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Usuario excluido com sucesso' 
                            ]);
    }

    public function test_edit_item()
    {   
        $this->get('/api/v1/user/1',[     
                                                "id" => "1",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                "name" => "admin",
                                "email" => "admin@tal.com.br",
                             ]);
    }
    public function test_list_two_items()
    {   
        $this->test_create_item();

        $this->get('/api/v1/users/',[])
                ->assertStatus(200)
                ->assertSeeText('admin')
                ->assertSeeText('novo usuario')
                ->assertSeeText('admin@tal.com.br')
                ->assertSeeText('novoemail@tal.com');
               
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
