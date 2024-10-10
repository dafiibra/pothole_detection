<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // Import your Admin model

class RehashAdminPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:rehash-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rehash all admin passwords in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve all admins
        $admins = Admin::all();

        foreach ($admins as $admin) {
            // Always hash the password since they are plain text
            $hashedPassword = Hash::make($admin->password);

            // Update the admin record with the hashed password
            Admin::where('username', $admin->username)
                ->update(['password' => $hashedPassword]);

            $this->info("Password for admin username '{$admin->username}' has been hashed.");
        }

        return 0;
    }
}
