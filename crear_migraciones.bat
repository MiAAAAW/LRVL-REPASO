@echo off
echo Creando todas las migraciones de RoomMatch...

echo Creando migración de usuarios...
echo ^<?php > database\migrations\2024_01_01_000001_create_users_table.php
echo. >> database\migrations\2024_01_01_000001_create_users_table.php
echo use Illuminate\Database\Migrations\Migration; >> database\migrations\2024_01_01_000001_create_users_table.php
echo use Illuminate\Database\Schema\Blueprint; >> database\migrations\2024_01_01_000001_create_users_table.php
echo use Illuminate\Support\Facades\Schema; >> database\migrations\2024_01_01_000001_create_users_table.php
echo. >> database\migrations\2024_01_01_000001_create_users_table.php
echo return new class extends Migration >> database\migrations\2024_01_01_000001_create_users_table.php
echo { >> database\migrations\2024_01_01_000001_create_users_table.php
echo     public function up^(^) >> database\migrations\2024_01_01_000001_create_users_table.php
echo     { >> database\migrations\2024_01_01_000001_create_users_table.php
echo         Schema::create^('users', function ^(Blueprint $table^) { >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>id^('id_usuario'^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>string^('nombre'^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>string^('correo'^)-^>unique^(^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>string^('contraseña'^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>enum^('tipo_usuario', ^['estudiante', 'propietario'^]^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>timestamp^('email_verified_at'^)-^>nullable^(^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>rememberToken^(^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo             $table-^>timestamps^(^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo         }^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo     } >> database\migrations\2024_01_01_000001_create_users_table.php
echo. >> database\migrations\2024_01_01_000001_create_users_table.php
echo     public function down^(^) >> database\migrations\2024_01_01_000001_create_users_table.php
echo     { >> database\migrations\2024_01_01_000001_create_users_table.php
echo         Schema::dropIfExists^('users'^); >> database\migrations\2024_01_01_000001_create_users_table.php
echo     } >> database\migrations\2024_01_01_000001_create_users_table.php
echo }; >> database\migrations\2024_01_01_000001_create_users_table.php

echo Migraciones creadas exitosamente!
echo Ahora ejecuta: php artisan migrate:fresh
