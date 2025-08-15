<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'question' => 'Berapa lama magang di BPS Provinsi Riau?',
                'answer' => 'Magang berlangsung selama 1 sampai 3 bulan tergantung kebijakan dan kebutuhan.',
            ],
            [
                'question' => 'Bisakah untuk konversi mata kuliah?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ],
            [
                'question' => 'Apakah magang ini paid atau unpaid?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ],
            [
                'question' => 'Apakah penempatan ditentukan langsung oleh BPS?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ]
        ];

        foreach ($data as $faq) {
            Faq::create($faq);
        }
    }
}
