<?php
namespace App\Console\Commands;

// Command: provides the base class for custom Artisan commands.
use Illuminate\Console\Command;

// User: represents an administrator account in the database.
use App\Models\User;

// Validator: checks that the administrator's details are valid.
use Illuminate\Support\Facades\Validator;

// Hash: securely hashes the password before storing it.
use Illuminate\Support\Facades\Hash;

// CreateAdminUser: creates an administrator account securely.
class CreateAdminUser extends Command
{
    // Command name used in the terminal.
    protected $signature = 'admin:create';

    // Short explanation shown in the Artisan command list.
    protected $description = 'Create an administrator account for CertTrack';

    // Run the administrator creation process.
    public function handle(): int
    {
        // Ask for the administrator's name.
        $name = $this->ask('Enter administrator name');

        // Ask for the administrator's email.
        $email = $this->ask('Enter administrator email');

        // Ask for the password without displaying it.
        $password = $this->secret('Enter administrator password');

        // Ask the user to confirm the password privately.
        $passwordConfirmation = $this->secret('Confirm administrator password');

        // Validate the submitted information.
        $validator = Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $passwordConfirmation,
            ],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:12', 'confirmed'],
            ]
        );

        // Stop if any information is invalid.
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        // Create the administrator account.
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Confirm that the account was created.
        $this->info('Administrator account created successfully.');

        return self::SUCCESS;
    }
}