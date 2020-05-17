<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateUserCommand extends Command
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
    protected $description = 'Create a new user';

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
        $user = User::create([
            'email' => $this->getEmail(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'role' => $this->getRole(),
        ]);

        $this->info("User {$user->email} created successfully.");

        event(new \App\Events\Users\CreatedEvent($user));
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        $email = $this->ask('Email address');

        $validator = Validator::make([
            'email' => $email,
        ], [
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return $this->getEmail();
        }

        return $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        $firstName = $this->ask('First name');

        $validator = Validator::make([
            'first_name' => $firstName,
        ], [
            'first_name' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return $this->getFirstName();
        }

        return $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        $lastName = $this->ask('Last name');

        $validator = Validator::make([
            'last_name' => $lastName,
        ], [
            'last_name' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return $this->getLastName();
        }

        return $lastName;
    }

    /**
     * @return string|null
     */
    public function getRole()
    {
        $type = $this->choice('Role', ['User', 'Admin', 'Owner'], 0);

        if ($type != 'User') {
            return strtolower($type);
        }

        return null;
    }
}
