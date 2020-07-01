<?php

namespace App\Console\Commands;

use App\Models\User;
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
    protected $signature = 'make:user {--a|admin} {--o|owner} {--u|user}';

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
        $email = $this->getEmail();
        $firstName = $this->getFirstName();
        $lastName = $this->getLastName();
        $role = $this->getRole();

        if (! $email || ! $firstName || ! $lastName) {
            return;
        }

        $user = User::onlyTrashed()->updateOrCreate([
            'email' => $email,
        ], [
            'deleted_at' => null,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'role' => $role,
        ]);

        $this->info("User created with the email address {$user->email}.");

        event(new \App\Events\Users\CreatedEvent($user));
    }

    /**
     * @return mixed
     */
    protected function getEmail()
    {
        $email = $this->option('no-interaction') ? env('USER_EMAIL') : $this->ask('Email address');

        $validator = Validator::make([
            'email' => $email,
        ], [
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            if ($this->option('no-interaction')) {
                return;
            }

            return $this->getEmail();
        }

        return $email;
    }

    /**
     * @return mixed
     */
    protected function getFirstName()
    {
        $firstName = $this->option('no-interaction') ? env('USER_FIRST_NAME') : $this->ask('First name');

        $validator = Validator::make([
            'first_name' => $firstName,
        ], [
            'first_name' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            if ($this->option('no-interaction')) {
                return;
            }

            return $this->getFirstName();
        }

        return $firstName;
    }

    /**
     * @return mixed
     */
    protected function getLastName()
    {
        $lastName = $this->option('no-interaction') ? env('USER_LAST_NAME') : $this->ask('Last name');

        $validator = Validator::make([
            'last_name' => $lastName,
        ], [
            'last_name' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            if ($this->option('no-interaction')) {
                return;
            }

            return $this->getLastName();
        }

        return $lastName;
    }

    /**
     * @return string|null
     */
    protected function getRole()
    {
        if ($this->option('admin')) {
            return 'admin';
        }

        if ($this->option('owner')) {
            return 'owner';
        }

        $type = $this->option('no-interaction') ? ucfirst(env('USER_ROLE', 'user')) : $this->choice('Role', ['User', 'Admin', 'Owner'], 0);

        if ($type != 'User') {
            return strtolower($type);
        }

        return null;
    }
}
