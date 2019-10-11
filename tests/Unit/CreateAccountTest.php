<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class CreateAccountTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic unit test example.
     * @return void
     */
    /*
    public function testExample()
    {
       // $this->assertTrue(true);
    }
    */

    public function testCreateAccountPageHeaders()
    {
        $data = [
            'first_name' => "John",
            'last_name' => "Peter",
            'dob' => "06/11/2019"
        ];

        $response = $this->get(route('create_account'));
        $response->dumpHeaders();
    }


    public function testGetCreateAccountPathReturnsCreateAccountView()
    {
        $response = $this->get(route('show_create_account'));
        $response->assertViewIs('project_views.authentication_views.create_account');
    }

    /** 
     * @group account_creation
     */
    public function testCreateAccountFunctionCreatesAccount()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Peter',
            'dob' => '1996-01-01',
            'password' => '1234567',
            'email' => 'John@gmail.com',
            'role' => 'teacher',
            'phone_number' => '049324'
        ];

        $response = $this->post(route('create_account'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'f_name' => 'John',
            'l_name' => 'Peter',
            'dob' => '1996-01-01',
            'email' => 'John@gmail.com',
            'role_id' => 1,
            'phone_number' => '049324'
        ]);
    }

    /** 
    *
    * @group create_account_login
    */
    public function testCreateAccountFunctionLogsUserIn()
    {
        $this->withoutExceptionHandling();
        $data = [
            'first_name' => 'John',
            'last_name' => 'Peter',
            'dob' => '1996-01-01',
            'password' => '1234567',
            'email' => 'John@gmail.com',
            'role' => 'teacher',
            'phone_number' => '049324'
        ];

        $response = $this->post(route('create_account'), $data);
        //$response->assertStatus(200);

        $this->assertAuthenticated($guard=null);
    }

    
}
