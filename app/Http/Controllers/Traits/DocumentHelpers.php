<?php

namespace App\Http\Controllers\Traits;

trait DocumentHelpers
{
    /**
     * Mengubah angka bulan (1-12) menjadi angka Romawi (I-XII).
     *
     * @param int $monthNumber Angka bulan dari 1 sampai 12.
     * @return string Angka Romawi atau string kosong jika input tidak valid.
     */
    private function getRomanMonth(int $monthNumber): string
    {
        // Peta sederhana untuk bulan
        $romanMonths = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        // Kembalikan nilai Romawi jika ada di peta, jika tidak, kembalikan string kosong
        return $romanMonths[$monthNumber] ?? '';
    }

    // Kamu bisa menambahkan fungsi helper lain terkait dokumen di sini di masa depan
}
