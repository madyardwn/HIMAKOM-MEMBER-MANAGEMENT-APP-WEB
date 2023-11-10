<?php

namespace App\Imports;

use App\Models\Cabinet;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
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
        $role = Role::where('name', $row['role'])->first();

        if (!$cabinet) {
            throw new \Exception('Cabinet with name ' . $row['cabinet'] . ' not found!');
        }

        if (!$role) {
            throw new \Exception('Role with name ' . $row['role'] . ' not found!');
        }

        if ($user === null) {
            $user = User::create([
                'nim' => $row['nim'],
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']),
                'year' => $row['year'],
                'gender' => $row['gender'],
                'cabinet_id' => $cabinet->id,

                // NULLABLE DATA
                'department_id' => $department->id ?? null,
                'name_bagus' => $row['name_bagus'] ?? null,
                'npa' => $row['npa'] ?? null,
                'picture' => $row['picture'] ?? null,
            ]);

            $user->roles()->sync($role->id);

            WorkHistory::create([
                'user_id' => $user->id,
                'cabinet_id' => $cabinet->id,
                'department_id' => $department->id ?? null,
                'role_id' => $role->id,
                'start_date' => Carbon::now(),
            ]);

            return $user;
        }

        if ($user->name_bagus !== $row['name_bagus'] ?? null) {
            $user->name_bagus = $row['name_bagus'] ?? null;
        }

        if ($user->npa !== $row['npa'] ?? null) {
            $user->npa = $row['npa'] ?? null;
        }

        if ($user->picture !== $row['picture'] ?? null) {
            $user->picture = $row['picture'] ?? null;
        }

        if ($user->department_id !== $department->id ?? null) {
            $user->department_id = $department->id ?? null;
        }

        if ($user->cabinet_id !== $cabinet->id) {
            $user->cabinet_id = $cabinet->id;
        }

        $user->save();

        if ($user->roles()->where('role_id', $role->id)->first() === null) {
            $user->roles()->sync($role->id);
        }

        $workHistory = WorkHistory::where('user_id', $user->id)
            ->where('cabinet_id', $cabinet->id)
            ->where('department_id', $department->id ?? null)
            ->where('role_id', $role->id)
            ->first();

        if ($workHistory === null) {
            WorkHistory::create([
                'user_id' => $user->id,
                'cabinet_id' => $cabinet->id,
                'department_id' => $department->id ?? null,
                'role_id' => $role->id,
                'start_date' => Carbon::now(),
            ]);
        }

        return null;
    }
}
