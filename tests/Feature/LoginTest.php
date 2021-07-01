<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Funcionamiento de la página de login.
     *
     * @return void
     */
    public function test_pagina_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Funcionamiento de rutas privadas en web
     *
     * @return void
     */
    public function test_denegar_accesso_web()
    {
        $response = $this->withSession(['banned' => false])
                    ->get('/student');

        $response->assertStatus(302);

        $user = User::factory()->sinPrograma()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])
                    ->get('/student');

        $response->assertStatus(302);
    }

    /**
     * Funcionamiento de rutas privadas en api
     *
     * @return void
     */
    public function test_denegar_accesso_api()
    {
        $response = $this->withSession(['banned' => false])
                    ->get('/api/user');

        $response->assertStatus(302);

        $user = User::factory()->sinPrograma()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])
                    ->get('/api/user');

        $response->assertStatus(302);
    }

    /**
     * Funcionamiento de rutas privadas en web
     *
     * @return void
     */
    public function test_acceso_web()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])
                    ->get('/student');

        $response->assertStatus(200);
    }

    /**
     * Funcionamiento de rutas privadas en api
     *
     * @return void
     */
    public function test_acceso_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])
                    ->get('/api/user');

        $response->assertStatus(200);
    }

}
