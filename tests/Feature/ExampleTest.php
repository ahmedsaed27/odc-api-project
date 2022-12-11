<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_login(){
        $auth = $this->postJson('http://127.0.0.1:8000/api/login' , [
            'email' => 'user@gmail.com',
            'password' => 'password',
            'name' => 'User',
            'api_password' => 'odcAPOXZASSAFAS@@BCSA'
        ]);
        $auth->assertStatus(200)->assertJson(['status' => 'success']);
    }
}
