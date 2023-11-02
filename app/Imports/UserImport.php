<?php

namespace App\Imports;

use App\Models\Cabinet;
use App\Models\Department;
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

        if ($user) {
            $user->update([
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
