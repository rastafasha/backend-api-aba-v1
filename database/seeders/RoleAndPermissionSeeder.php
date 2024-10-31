<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            ['id' => 1, 'name' => 'register_rol', 'guard_name' => 'api'],
            ['id' => 2, 'name' => 'list_rol', 'guard_name' => 'api'],
            ['id' => 3, 'name' => 'edit_rol', 'guard_name' => 'api'],
            ['id' => 4, 'name' => 'delete_rol', 'guard_name' => 'api'],
            ['id' => 9, 'name' => 'profile_doctor', 'guard_name' => 'api'],
            ['id' => 10, 'name' => 'register_patient', 'guard_name' => 'api'],
            ['id' => 11, 'name' => 'list_patient', 'guard_name' => 'api'],
            ['id' => 12, 'name' => 'edit_patient', 'guard_name' => 'api'],
            ['id' => 13, 'name' => 'delete_patient', 'guard_name' => 'api'],
            ['id' => 14, 'name' => 'profile_patient', 'guard_name' => 'api'],
            ['id' => 19, 'name' => 'register_appointment', 'guard_name' => 'api'],
            ['id' => 20, 'name' => 'list_appointment', 'guard_name' => 'api'],
            ['id' => 21, 'name' => 'edit_appointment', 'guard_name' => 'api'],
            ['id' => 22, 'name' => 'delete_appointment', 'guard_name' => 'api'],
            ['id' => 27, 'name' => 'show_payment', 'guard_name' => 'api'],
            ['id' => 28, 'name' => 'edit_payment', 'guard_name' => 'api'],
            ['id' => 29, 'name' => 'activitie', 'guard_name' => 'api'],
            ['id' => 30, 'name' => 'calendar', 'guard_name' => 'api'],
            ['id' => 31, 'name' => 'expense_report', 'guard_name' => 'api'],
            ['id' => 32, 'name' => 'invoice_report', 'guard_name' => 'api'],
            ['id' => 33, 'name' => 'settings', 'guard_name' => 'api'],
            ['id' => 34, 'name' => 'list_insurance', 'guard_name' => 'api'],
            ['id' => 35, 'name' => 'register_insurance', 'guard_name' => 'api'],
            ['id' => 36, 'name' => 'list_bip', 'guard_name' => 'api'],
            ['id' => 37, 'name' => 'register_bip', 'guard_name' => 'api'],
            ['id' => 38, 'name' => 'edit_bip', 'guard_name' => 'api'],
            ['id' => 39, 'name' => 'attention_bip', 'guard_name' => 'api'],
            ['id' => 40, 'name' => 'admin_dashboard', 'guard_name' => 'api'],
            ['id' => 41, 'name' => 'doctor_dashboard', 'guard_name' => 'api'],
            ['id' => 42, 'name' => 'client_dashboard', 'guard_name' => 'api'],
            ['id' => 43, 'name' => 'list_employers', 'guard_name' => 'api'],
            ['id' => 44, 'name' => 'register_employer', 'guard_name' => 'api'],
            ['id' => 45, 'name' => 'edit_employer', 'guard_name' => 'api'],
            ['id' => 46, 'name' => 'delete_employer', 'guard_name' => 'api'],
            ['id' => 47, 'name' => 'list_location', 'guard_name' => 'api'],
            ['id' => 48, 'name' => 'register_location', 'guard_name' => 'api'],
            ['id' => 49, 'name' => 'edit_location', 'guard_name' => 'api'],
            ['id' => 50, 'name' => 'edit_notebcba', 'guard_name' => 'api'],
            ['id' => 51, 'name' => 'list_notebcba', 'guard_name' => 'api'],
            ['id' => 52, 'name' => 'register_notebcba', 'guard_name' => 'api'],
            ['id' => 53, 'name' => 'view_bip', 'guard_name' => 'api'],
            ['id' => 54, 'name' => 'edit_noterbt', 'guard_name' => 'api'],
            ['id' => 55, 'name' => 'list_noterbt', 'guard_name' => 'api'],
            ['id' => 56, 'name' => 'register_noterbt', 'guard_name' => 'api'],
            ['id' => 57, 'name' => 'view_notebcba', 'guard_name' => 'api'],
            ['id' => 58, 'name' => 'view_noterbt', 'guard_name' => 'api'],
            ['id' => 59, 'name' => 'delete_noterbt', 'guard_name' => 'api'],
            ['id' => 60, 'name' => 'delete_notebcba', 'guard_name' => 'api'],
            ['id' => 61, 'name' => 'list_billing', 'guard_name' => 'api'],
            ['id' => 62, 'name' => 'list_patient_log_report', 'guard_name' => 'api'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles
        $roles = [
            ['id' => 1, 'name' => 'SUPERADMIN', 'guard_name' => 'api'],
            ['id' => 2, 'name' => 'MANAGER', 'guard_name' => 'api'],
            ['id' => 7, 'name' => 'BCBA', 'guard_name' => 'api'],
            ['id' => 8, 'name' => 'RBT', 'guard_name' => 'api'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Give all permissions to SUPERADMIN
        $superadminRole = Role::find(1);
        $superadminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to other roles
        $managerRole = Role::find(2);
        $bcbaRole = Role::find(7);
        $rbtRole = Role::find(8);

        // Add specific permission assignments here based on your requirements
    }
}
