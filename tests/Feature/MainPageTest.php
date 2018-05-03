<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainPageTest extends TestCase
{
    public function testRootUriShouldRedirectToLogin()
    {
        $this->get('/')->assertRedirect('login');
    }
}
