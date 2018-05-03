<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MainPageTest extends TestCase
{
    public function testRootUriShouldRedirectToLogin()
    {
        $this->get('/')->assertRedirect('login');
    }
}
