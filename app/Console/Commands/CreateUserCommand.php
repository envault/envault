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

            return;
        }

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

            return;
        }

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

            return;
        }

        $type = $this->choice('Role', ['User', 'Admin', 'Owner'], 0);

        $role = null;

        if ($type != 'User') {
            $role = strtolower($type);
        }

        $user = User::create([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'role' => $role,
        ]);

        $this->info('User created with the email address '.$email.'.');

        $user->log()->create([
            'action' => 'created',
            'description' => "{$user->full_name} ({$user->email}) was added as a user.",
        ]);
    }
}
