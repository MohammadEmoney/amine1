<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            "Fun Fun" => ['A', 'B', 'C'],
            "Pocket"  => ['A', 'B', 'C'],
            "Alphabet"  => ['A', 'B', 'C'],
            "First Friend"  => ['A', 'B', 'C'],
            "Family"  => ['A', 'B', 'C'],
            "File"  => ['A', 'B', 'C'],
            "FCE"  => ['A', 'B', 'C'],
            "IELTS"  => ['A', 'B', 'C'],
            "تربیت مدرس",
            "بحث آزاد",
            "مقدماتی",
            "پیشرفته",
            "مقدماتی",
            "متوسط",
            "پیشرفته",
            "FCE",
            "Online",
            "پک 5 جلسه ای",
            "پک 10 جلسه ای",
            "پک 50 جلسه ای",
            "پک 100 جلسه ای",
        ];

        foreach($data as $key => $value){
            Course::create([
                'title' => $key,
                'part_number' => $partNumber,
                'parent_id' => $this->data['parent_id'] ?? null,
                'age' => $this->data['course_age'],
                'type' => $this->data['course_type'],
                'price' => $this->data['price'],
                'sale_price' => $this->data['sale_price'],
            ]);
        }
    }
}
