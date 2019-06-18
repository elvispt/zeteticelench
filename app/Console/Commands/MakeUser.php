<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Allows making a user using artisan command make:user.
 * When running initial migration there is no user created, so this command
 * must be called to create a user.
 *
 * @package App\Console\Commands
 */
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
     * Execute the console command. If the caller provides invalid data,
     * error messages will be shown in the command line.
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

        try {
            $user = $this->createUser($name, $email, $password);
        } catch (QueryException $exception) {
            $errorMessage = "Failed to create user when storing into DB.";
            Log::error(
                $errorMessage,
                ['message' => $exception->getMessage()]
            );
            $this->error($errorMessage);
            return;
        }

        $id = $user->id;
        $name = $user->name;
        $email = $user->email;

        $this->info("User $name created with id $id");
        $this->info("Login with: $email and provided password.");
    }

    /**
     * Requests the necessary data for creating the user.
     *
     * @return array Returns the name, email, and password as an array.
     */
    protected function askUserData()
    {
        $name = $this->ask("Type name");
        $email = $this->ask("Type email (it will also be the username).");
        $password = $this->secret("Type your password");

        return [$name, $email, $password];
    }

    /**
     * The validation of the data is run against the rules defined here.
     *
     * @param string $name The name of the user
     * @param string $email The email of the user
     * @param string $password The password of the user
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    protected function validator(string $name, string $email, string $password)
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

    /**
     * Stores the given user information into database. Takes care of securely
     * hashing the given password.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User Returns the user model after storing into db.
     */
    protected function createUser(
        string $name,
        string $email,
        string $password
    ): User {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }
}
