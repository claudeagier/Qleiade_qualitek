<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait InteractsWithUsers
{
    public function setUpUser(array $attributes = [])
    {
        $this->logout();
      
        $this->user = User::factory()->create($attributes);

        $this->login();

        return $this;
    }

    public function setUserTest(){
        $this->logout();

        $suerId_test = 1;
        $this->user = User::find($suerId_test);
        return $this;
    }

    public function login()
    {
        $this->actingAs($this->user);
    }
    
    public function logout()
    {
        $this->user = null;
    }
}