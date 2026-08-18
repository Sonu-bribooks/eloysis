<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use Illuminate\Database\Seeder;

class AcademicSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $AcademicSession = [
            [
                'name' => '2025-2026',
                'start_year' => '2025',
                'end_year' => '2026',
                'start_date' => '2025-04-01',
                'end_date' => '2026-03-31',
                'status' => true,
                'is_current' => false,
            ],
            [
                'name' => '2026-2027',
                'start_year' => '2026',
                'end_year' => '2027',
                'start_date' => '2026-04-01',
                'end_date' => '2027-03-31',
                'status' => true,
                'is_current' => true,
            ],
        ];

        foreach ($AcademicSession as $session) {
            AcademicSession::updateOrCreate(
                ['name' => $session['name']],
                [
                    'start_date' => $session['start_date'],
                    'end_date' => $session['end_date'],
                    'status' => $session['status'],
                    'start_year' => $session['start_year'],
                    'end_year' => $session['end_year'],
                    'is_current' => $session['is_current'],
                ]
            );
        }
    }
}
