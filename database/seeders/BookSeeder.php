<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run()
    {
        $fantasi = Category::where('name', 'Novel Fantasi')->first();
        $romantis = Category::where('name', 'Novel Romantis')->first();
        $inspiratif = Category::where('name', 'Novel Inspiratif')->first();
        $filosofi = Category::where('name', 'Novel Filosofi')->first();

        Book::create([
            'category_id' => $fantasi->id,
            'isbn' => '978-602-7678-00-1',
            'title' => 'Bumi',
            'author' => 'Tere Liye',
            'description' => 'Petualangan Raib, Seli, dan Ali menemukan dunia paralel. Novel fantasi yang memukau tentang persahabatan dan keberanian.',
            'price' => 85000,
            'stock' => 20,
        ]);

        Book::create([
            'category_id' => $fantasi->id,
            'isbn' => '978-602-7678-01-8',
            'title' => 'Bulan',
            'author' => 'Tere Liye',
            'description' => 'Kelanjutan petualangan Raib dkk ke Klan Bulan. Penuh misteri dan aksi yang menegangkan dengan twist mengejutkan.',
            'price' => 85000,
            'stock' => 18,
        ]);

        Book::create([
            'category_id' => $fantasi->id,
            'isbn' => '978-602-7678-02-5',
            'title' => 'Matahari',
            'author' => 'Tere Liye',
            'description' => 'Rahasia besar terungkap di Klan Matahari. Novel penuh emosi yang mengharukan tentang pengorbanan dan cinta.',
            'price' => 90000,
            'stock' => 15,
        ]);

        Book::create([
            'category_id' => $romantis->id,
            'isbn' => '978-602-7678-03-2',
            'title' => 'Hujan',
            'author' => 'Tere Liye',
            'description' => 'Kisah cinta Lail dan Esok yang memilukan. Novel romantis yang mengajarkan tentang takdir dan penerimaan.',
            'price' => 95000,
            'stock' => 22,
        ]);

        Book::create([
            'category_id' => $filosofi->id,
            'isbn' => '978-602-7678-04-9',
            'title' => 'Pulang',
            'author' => 'Tere Liye',
            'description' => 'Perjalanan spiritual Bujang mencari jati diri. Novel penuh filosofi tentang arti pulang yang sesungguhnya.',
            'price' => 88000,
            'stock' => 19,
        ]);

        Book::create([
            'category_id' => $romantis->id,
            'isbn' => '978-602-7678-05-6',
            'title' => 'Funiculi Funicula',
            'author' => 'Unknown',
            'description' => 'Kafe ajaib yang bisa membawa kembali ke masa lalu. Novel Jepang yang menghangatkan hati tentang kesempatan kedua.',
            'price' => 98000,
            'stock' => 16,
        ]);

        Book::create([
            'category_id' => $inspiratif->id,
            'isbn' => '978-602-7678-06-3',
            'title' => 'Namaku Alam',
            'author' => 'Alam',
            'description' => 'Perjuangan anak jalanan yang gigih meraih mimpi. Novel inspiratif tentang kekuatan harapan dan pendidikan.',
            'price' => 75000,
            'stock' => 25,
        ]);

        Book::create([
            'category_id' => $romantis->id,
            'isbn' => '978-602-7678-07-0',
            'title' => 'Perahu Kertas',
            'author' => 'Dee',
            'description' => 'Kisah cinta Kugy dan Keenan yang penuh warna. Novel romantis yang mengajarkan tentang mimpi dan realita.',
            'price' => 92000,
            'stock' => 21,
        ]);

        Book::create([
            'category_id' => $inspiratif->id,
            'isbn' => '978-602-7678-08-7',
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'description' => 'Perjuangan 10 anak Belitung meraih pendidikan. Novel legendaris penuh inspirasi dan keberanian bermimpi.',
            'price' => 95000,
            'stock' => 23,
        ]);
    }
}