<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure the admin user exists with the specified credentials
        DB::table('users')->updateOrInsert(
            ['email' => 'aydiala123@gmail.com'],
            [
                'name'        => 'Admin EduMind',
                'password'    => Hash::make('12345679'),
                'role'        => 'admin',
                'is_approved' => true,
                'avatar'      => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&q=80',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the admin user if it matches the exact credentials (email only)
        DB::table('users')->where('email', 'aydiala123@gmail.com')->delete();
    }
};
