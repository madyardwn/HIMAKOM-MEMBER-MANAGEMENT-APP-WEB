<?php

namespace App\Imports;

use App\Models\Cabinet;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // ignore header or first row
        if (
            $row[0] == 'nim'
            && $row[1] == 'name'
            && $row[2] == 'email'
            && $row[3] == 'password'
            && $row[4] == 'year'
            && $row[5] == 'nama_bagus'
            && $row[6] == 'npa'
            && $row[7] == 'picture'
            && $row[8] == 'gender'

            && $row[9] == 'cabinet_name'
            && $row[10] == 'department_name'
            && $row[11] == 'role_name'
        ) {
            return null;
        }

        $user = User::where('nim', $row[0])->first();

        $cabinet = Cabinet::where('name', $row[9])->first();
        $department = Department::where('short_name', $row[10])->first();
        $roles = Role::where('name', $row[11])->first();

        if (!$department) {
            throw new \Exception('Department with short name ' . $row[10] . ' not found!');
        }

        if (!$cabinet) {
            throw new \Exception('Cabinet with name ' . $row[9] . ' not found!');
        }

        if (!$roles) {
            throw new \Exception('Role with name ' . $row[11] . ' not found!');
        }

        if ($user) { // Import at second time

            // Add new Cabinet
            if (strcmp($row[9], $user->cabinets()->first()->name) != 0) {
                $user->cabinets()->attach($cabinet->id);
            }

            // Add new Role
            if (strcmp($row[11], $user->roles()->first()->name) != 0) {
                $user->assignRole($roles->name);
            }

            return null;
        }

        $user = User::create([
            'nim' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'password' => bcrypt($row[3]),
            'year' => $row[4],
            'name_bagus' => $row[5],
            'npa' => $row[6],
            'picture' => $row[7],
            'gender' => $row[8],
            'department_id' => $department->id,
        ]);

        $user->cabinets()->sync($cabinet->id);
        $user->assignRole($row[11]);

        return $user;
    }
}
