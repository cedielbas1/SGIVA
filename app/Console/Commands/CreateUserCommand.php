<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create
                            {--name= : El nombre del usuario}
                            {--email= : El email del usuario}
                            {--password= : La contraseña del usuario}
                            {--role=user : El rol del usuario (user, admin, super_admin)}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Crear un nuevo usuario en SGIVA de forma segura';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->option('name') ?? $this->ask('¿Cuál es el nombre del usuario?');
        $email = $this->option('email') ?? $this->ask('¿Cuál es el email del usuario?');
        $password = $this->option('password') ?? $this->secret('¿Cuál es la contraseña del usuario?');
        $role = $this->option('role') ?? $this->choice('¿Cuál es el rol del usuario?', ['user', 'admin', 'super_admin'], 0);

        // Validar
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin,super_admin',
        ]);

        if ($validator->fails()) {
            $this->error('Validación fallida:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  • {$error}");
            }
            return 1;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
            ]);

            $this->info("✅ Usuario creado exitosamente");
            $this->line("");
            $this->table(
                ['Propiedad', 'Valor'],
                [
                    ['ID', $user->id],
                    ['Nombre', $user->name],
                    ['Email', $user->email],
                    ['Rol', $user->role],
                    ['Creado', $user->created_at->format('Y-m-d H:i:s')],
                ]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error("Error al crear el usuario: {$e->getMessage()}");
            return 1;
        }
    }
}
