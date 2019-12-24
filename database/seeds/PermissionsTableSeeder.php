<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Users
        Permission::create([
            'name'        => 'Navegar usuarios',
            'slug'        => 'users.index',
            'description' => 'Lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
            'name'        => 'Ver detalle de usuario',
            'slug'        => 'users.show',
            'description' => 'Ver en detalle cada usuario del sistema',
        ]);
        Permission::create([
            'name'        => 'Edicion de usuarios',
            'slug'        => 'users.edit',
            'description' => 'Editar cualquier dato de un usuario del sistema',
        ]);
        Permission::create([
            'name'        => 'Eliminar usuarios',
            'slug'        => 'users.destroy',
            'description' => 'Eliminar cualquier usuario del sistema',
        ]);
        Permission::create([
            'name'        => 'Creacion de usuarios',
            'slug'        => 'users.create',
            'description' => 'Crear usuarios en el sistema',
        ]);

//***************************************************************************************** */

        //Roles
        Permission::create([
            'name'        => 'Navegar roles',
            'slug'        => 'roles.index',
            'description' => 'Lista y navega todos los roles del sistema',
        ]);
        Permission::create([
            'name'        => 'Ver detalle de rol',
            'slug'        => 'roles.show',
            'description' => 'Ver en detalle cada rol del sistema',
        ]);
        Permission::create([
            'name'        => 'Edicion de roles',
            'slug'        => 'roles.edit',
            'description' => 'Editar cualquier dato de un rol del sistema',
        ]);
        Permission::create([
            'name'        => 'Eliminar roles',
            'slug'        => 'roles.destroy',
            'description' => 'Eliminar cualquier rol del sistema',
        ]);
        Permission::create([
            'name'        => 'Creacion de roles',
            'slug'        => 'roles.create',
            'description' => 'Crear roles en el sistema',
        ]);

//***************************************************************************************** */

        //Incidencias
        Permission::create([
            'name'        => 'Navegar incidencias',
            'slug'        => 'incidents.index',
            'description' => 'Lista y navega todas los incidencias del sistema',
        ]);
        Permission::create([
            'name'        => 'Ver detalle de incidencia',
            'slug'        => 'incidents.show',
            'description' => 'Ver en detalle cada incidencia del sistema',
        ]);
        Permission::create([
            'name'        => 'Edicion de incidencias',
            'slug'        => 'incidents.edit',
            'description' => 'Editar cualquier dato de un incidencia del sistema',
        ]);
        Permission::create([
            'name'        => 'Eliminar incidencias',
            'slug'        => 'incidents.destroy',
            'description' => 'Eliminar cualquier incidencia del sistema',
        ]);
        Permission::create([
            'name'        => 'Creacion de incidencias',
            'slug'        => 'incidents.create',
            'description' => 'Crear incidencias en el sistema',
        ]);

//***************************************************************************************** */

        //Equipos
        Permission::create([
            'name'        => 'Navegar equipos',
            'slug'        => 'equipaments.index',
            'description' => 'Lista y navega todas los equipos del sistema',
        ]);
        Permission::create([
            'name'        => 'Ver detalle de equipo',
            'slug'        => 'equipaments.show',
            'description' => 'Ver en detalle cada equipo del sistema',
        ]);
        Permission::create([
            'name'        => 'Edicion de equipos',
            'slug'        => 'equipaments.edit',
            'description' => 'Editar cualquier dato de un equipo del sistema',
        ]);
        Permission::create([
            'name'        => 'Eliminar equipos',
            'slug'        => 'equipaments.destroy',
            'description' => 'Eliminar cualquier equipo del sistema',
        ]);
        Permission::create([
            'name'        => 'Creacion de equipos',
            'slug'        => 'equipaments.create',
            'description' => 'Crear equipos en el sistema',
        ]);

//***************************************************************************************** */

        //Departamentos
        Permission::create([
            'name'        => 'Navegar departamentos',
            'slug'        => 'departaments.index',
            'description' => 'Lista y navega todas los departamentos del sistema',
        ]);
        Permission::create([
            'name'        => 'Ver detalle de departamento',
            'slug'        => 'departaments.show',
            'description' => 'Ver en detalle cada departamento del sistema',
        ]);
        Permission::create([
            'name'        => 'Edicion de departamentos',
            'slug'        => 'departaments.edit',
            'description' => 'Editar cualquier dato de un departamento del sistema',
        ]);
        Permission::create([
            'name'        => 'Eliminar departamentos',
            'slug'        => 'departaments.destroy',
            'description' => 'Eliminar cualquier departamento del sistema',
        ]);
        Permission::create([
            'name'        => 'Creacion de departamentos',
            'slug'        => 'departaments.create',
            'description' => 'Crear departamentos en el sistema',
        ]);

    }
}
