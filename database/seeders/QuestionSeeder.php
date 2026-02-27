<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'title' => 'Akses Telu Care',
            'category' =>  [
                'unit' => [
                    'id' => 'bd646c5d-5521-11ee-akd1-04d4c477450f',
                    'name' => 'Akademik'
                ],
                'service' => [
                    'id' => '7196ad8a-2182-4a8b-868e-7b80c1d60071',
                    'name' => 'Tel-U Care'
                ]
            ],
            'question' => 'Saya tidak bisa login menggunakan SSO saya.',
        ]);
    }

}
