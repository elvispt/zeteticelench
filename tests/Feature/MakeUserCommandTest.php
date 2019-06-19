<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakeUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUser()
    {
        $this->artisan('make:user')
            ->expectsQuestion('Type name', 'Test User')
            ->expectsQuestion(
                'Type email (it will also be the username).',
                'email@email.com'
            )
            ->expectsQuestion('Type your password', '123')
            ->expectsOutput('User Test User created with id 1')
            ->expectsOutput('Login with: email@email.com / <PASSWORD>')
            ->assertExitCode(0);
    }

    public function testCreateUserFailsWithMissingName()
    {
        $this->artisan('make:user')
             ->expectsQuestion('Type name', '')
             ->expectsQuestion(
                 'Type email (it will also be the username).',
                 'email@email.com'
             )
             ->expectsQuestion('Type your password', '123')
             ->expectsOutput('The name field is required.')
             ->assertExitCode(0);
    }

    public function testCreateUserFailsWithMissingEmail()
    {
        $this->artisan('make:user')
             ->expectsQuestion('Type name', 'Name here')
             ->expectsQuestion(
                 'Type email (it will also be the username).',
                 ''
             )
             ->expectsQuestion('Type your password', '123')
             ->expectsOutput('The email field is required.')
             ->assertExitCode(0);
    }

    public function testCreateUserFailsWithInvalidEmail()
    {
        $this->artisan('make:user')
             ->expectsQuestion('Type name', 'Name here')
             ->expectsQuestion(
                 'Type email (it will also be the username).',
                 'ads333'
             )
             ->expectsQuestion('Type your password', '123')
             ->expectsOutput('The email must be a valid email address.')
             ->assertExitCode(0);
    }

    public function testCreateUserFailsWithMissingPassword()
    {
        $this->artisan('make:user')
             ->expectsQuestion('Type name', 'Name here')
             ->expectsQuestion(
                 'Type email (it will also be the username).',
                 'email@mail.com'
             )
             ->expectsQuestion('Type your password', '')
             ->expectsOutput('The password field is required.')
             ->assertExitCode(0);
    }

    public function testCreateUserFailsWithAllFieldsMissing()
    {
        $this->artisan('make:user')
             ->expectsQuestion('Type name', '')
             ->expectsQuestion(
                 'Type email (it will also be the username).',
                 ''
             )
             ->expectsQuestion('Type your password', '')
             ->expectsOutput('The name field is required.')
             ->expectsOutput('The email field is required.')
             ->expectsOutput('The password field is required.')
             ->assertExitCode(0);
    }
}
