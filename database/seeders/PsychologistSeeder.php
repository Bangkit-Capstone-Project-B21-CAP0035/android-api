<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Psychologist;

class PsychologistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Psychologist::insert([
            'name' => 'Dr. Dra. Elly Yuliandari Gunatirin, M.Si - RS PHC Surabaya',
            'description' => 'Dr. Dra. Elly Yuliandari Gunatirin, M.Si adalah seorang Psikolog yang berpraktik di RS PHC Surabaya. Beliau dapat membantu layanan Konsultasi psikolog.',
            'gmap' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15833.150520526644!2d112.736692!3d-7.207991!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x85595a043d698089!2sRS%20PHC%20Surabaya!5e0!3m2!1sid!2sus!4v1622020409331!5m2!1sid!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        ]);
    }
}
