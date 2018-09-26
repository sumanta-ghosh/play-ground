<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use App\User;

class LoginTest extends TestCase {

    public function testRequiresEmailAndLogin() {
        $this->json('POST', 'api/login')
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => [
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                    ]
        ]);
    }

    public function testUserLoginsSuccessfully() {
        factory(User::class)->create([
            'email' => 'sumanta@example.com',
            'password' => bcrypt('123456'),
        ]);

        $payload = ['email' => 'sumanta@example.com', 'password' => '123456'];

        $this->json('POST', 'api/login', $payload)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                        'api_token',
                    ],
        ]);
    }

}
