<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email : Email pengguna yang akan dijadikan admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memberikan hak akses admin kepada pengguna';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Pengguna dengan email {$email} tidak ditemukan.");
            return 1;
        }
        
        $user->is_admin = true;
        $user->save();
        
        $this->info("Pengguna {$user->name} ({$email}) sekarang memiliki hak akses admin.");
        
        return 0;
    }
} 