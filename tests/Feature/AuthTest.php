<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSignup()
    {
        // user's data
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];
        // send post request
        $response = $this->json('POST', route('api.signup'), $data);
        //assert it was successful
        $this->assertArrayHasKey('token', $response->json());
        // delete data
        User::where('email', 'test@gmail.com')->delete();
    }

    public function testLogin()
{
    //Create user
    User::create([
        'name' => 'test',
        'email'=>'test@gmail.com',
        'password' => bcrypt('secret1234')
    ]);
    //attempt login
    $response = $this->json('POST',route('api.login'),[
        'email' => 'test@gmail.com',
        'password' => 'secret',
    ]);
    //Assert it was successful and a token was received
    $response->assertStatus(200);
    $this->assertArrayHasKey('token',$response->json());
    //Delete the user
    User::where('email','test@gmail.com')->delete();
}
}
