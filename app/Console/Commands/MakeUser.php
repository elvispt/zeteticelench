<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        [$name, $email, $password] = $this->askUserData();
        $validator = $this->validator($name, $email, $password);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        $user = $this->createUser($name, $email, $password);
        $id = $user->id;
        $name = $user->name;
        $email = $user->email;

        $this->info("User $name created with id $id");
        $this->info("Login with: $email and provided password.");
    }

    protected function askUserData()
    {
        $name = $this->ask("Type name");
        $email = $this->ask("Type email (it will also be the username).");
        $password = $this->secret("Type your password");

        return [$name, $email, $password];
    }

    /**
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    protected function validator($name, $email, $password)
    {
        return Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
            [
                'name' => ['required', 'string', 'min:1', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:1', 'max:100'],
            ]
        );
    }

    protected function createUser($name, $email, $password): User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
        return $user;
    }
}
