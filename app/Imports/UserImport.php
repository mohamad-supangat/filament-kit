<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row): void
    {
        $user = User::withTrashed()->updateOrCreate([
            'username'  => $row['kode_karyawan_username'],
        ], [
            'name' => $row['nama_karyawan'],
        ]);

        $user->assignRole($row['jenis_karyawan']);
    }
}
