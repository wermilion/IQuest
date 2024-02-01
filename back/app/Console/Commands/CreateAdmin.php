<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает пользователя-админа';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('Enter an email:');
        $password = $this->ask('Enter a password:');

        $this->validateArguments([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => Role::query()->where('name', 'admin')->first()->value('id')
        ]);

        $this->info('Admin created successfully');
    }

    protected function validateArguments($data)
    {
        $validator = Validator::make($data, [
            'name' => 'min:1',
            'email' => 'email',
            'password' => 'min:8',
        ]);

        if ($validator->fails()) {
            $this->error('The given arguments are invalid.');

            collect($validator->errors()->all())
                ->each(fn($error) => $this->line($error));
            exit;
        }

        return $validator;
    }
}
