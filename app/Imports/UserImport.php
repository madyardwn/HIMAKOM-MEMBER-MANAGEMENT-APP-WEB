<?php

namespace App\Imports;

use App\Models\Cabinet;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::where('nim', $row['nim'])->first();
        $cabinet = Cabinet::where('name', $row['cabinet'])->first();
        $department = Department::where('short_name', $row['department'])->first();
        $roles = Role::where('name', $row['role'])->first();

        if (!$cabinet) {
            throw new \Exception('Cabinet with name ' . $row[9] . ' not found!');
        }

        if (!$roles) {
            throw new \Exception('Role with name ' . $row[11] . ' not found!');
        }

        if ($user) { // Import at second time, for add missing data or regeneration

            // Update user
            $user->name_bagus = $row['nama bagus'] ?? null; // 'nama bagus' is 'name_bagus
            $user->npa = $row['npa'] ?? null;
            $user->picture = $row['picture'] ?? null;
            $user->department_id = $department->id ?? null;
            $user->cabinet_id = $cabinet->id;
            $user->save();

            // Add new Role
            $user->roles()->sync($roles->id);

            // Add new WorkHistory
            WorkHistory::create([
                'user_id' => $user->id,
                'cabinet_id' => $cabinet->id,
                'department_id' => $department->id ?? null,
                'role_id' => $roles->id,
                'start_date' => Carbon::now(),
            ]);

            return null;
        }

        $user = User::create([
            'nim' => $row['nim'], // 'nim' is 'nim
            'name' => $row['nama'], // 'nama' is 'name
            'email' => $row['email'],
            'password' => bcrypt($row['password']), // 'password' is 'password
            'year' => $row['year'],
            'name_bagus' => $row['nama bagus'] ?? null, // 'nama bagus' is 'name_bagus
            'npa' => $row['npa'] ?? null,
            'picture' => $row['picture'] ?? null,
            'gender' => $row['gender'],
            'department_id' => $department->id ?? null,
            'cabinet_id' => $cabinet->id,
        ]);

        $user->roles()->sync($roles->id);

        WorkHistory::create([
            'user_id' => $user->id,
            'cabinet_id' => $cabinet->id,
            'department_id' => $department->id ?? null,
            'role_id' => $roles->id,
            'start_date' => Carbon::now(),
        ]);

        return $user;
    }
}
