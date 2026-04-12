<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Roles;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("permission_level");
            $table->timestamps();
        });

        DB::table("roles")->insert([
            [
                'name' => 'Administrator',
                'permission_level' => Roles::ADMINISTRATOR,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Member',
                'permission_level' => Roles::DAFTAR_BUKU | Roles::PINJAM_BUAT | Roles::PINJAM_LIHAT_SENDIRI | Roles::PINJAM_BATAL,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
