<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Buku;
use Illuminate\Support\Str;

class BukuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories for library
        $categories = [
            'Fiksi',
            'Non-Fiksi',
            'Sejarah',
            'Sains',
            'Teknologi',
            'Biografi',
            'Pendidikan',
            'Agama',
            'Sosial',
            'Kesehatan'
        ];

        $categoryIds = [];
        
        // Create categories
        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(
                ['nama' => $cat],
                ['image' => null]
            );
            $categoryIds[] = $category->id;
        }

        // Sample books for each category (10 books per category)
        $booksPerCategory = [
            'Fiksi' => [
                ['judul' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'year' => 2005],
                ['judul' => 'Ronggeng Dukuh Paruk', 'author' => 'Ahmad Tohari', 'year' => 1982],
                ['judul' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'year' => 1980],
                ['judul' => 'Ayat-Ayat Cinta', 'author' => 'Habiburrahman El Shirazy', 'year' => 2004],
                ['judul' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'year' => 2009],
                ['judul' => 'Perahu Kertas', 'author' => 'Dee Lestari', 'year' => 2009],
                ['judul' => 'Sang Pemimpi', 'author' => 'Andrea Hirata', 'year' => 2006],
                ['judul' => 'Lelaki Harimau', 'author' => 'Eka Kurniawan', 'year' => 2004],
                ['judul' => 'Cantik Itu Luka', 'author' => 'Eka Kurniawan', 'year' => 2002],
                ['judul' => 'Pulang', 'author' => 'Leila S. Chudori', 'year' => 2012],
            ],
            'Non-Fiksi' => [
                ['judul' => 'Indonesia Dalam Arus Sejarah', 'author' => 'Tim Redaksi', 'year' => 2012],
                ['judul' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'year' => 2019],
                ['judul' => 'Rich Dad Poor Dad', 'author' => 'Robert Kiyosaki', 'year' => 1997],
                ['judul' => 'Atomic Habits', 'author' => 'James Clear', 'year' => 2018],
                ['judul' => 'Mindset', 'author' => 'Carol Dweck', 'year' => 2006],
                ['judul' => 'The 7 Habits', 'author' => 'Stephen Covey', 'year' => 1989],
                ['judul' => 'Deep Work', 'author' => 'Cal Newport', 'year' => 2016],
                ['judul' => 'Sejarah Dunia Yang Disembunyikan', 'author' => 'Jonathan Black', 'year' => 2007],
                ['judul' => 'Homo Deus', 'author' => 'Yuval Noah Harari', 'year' => 2015],
                ['judul' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'year' => 2011],
            ],
            'Sejarah' => [
                ['judul' => 'Sejarah Indonesia Modern', 'author' => 'M.C. Ricklefs', 'year' => 1981],
                ['judul' => 'Tragedi Nasional', 'author' => 'Taufik Abdullah', 'year' => 2005],
                ['judul' => 'Kemerdekaan Indonesia', 'author' => 'George Kahin', 'year' => 1952],
                ['judul' => 'Soekarno: Biografi Politik', 'author' => 'Bernhard Dahm', 'year' => 1987],
                ['judul' => 'Perang Diponegoro', 'author' => 'Peter Carey', 'year' => 2007],
                ['judul' => 'Masa Lampau Indonesia', 'author' => 'Sartono Kartodirdjo', 'year' => 1975],
                ['judul' => 'Revolusi Indonesia', 'author' => 'Anthony Reid', 'year' => 1974],
                ['judul' => 'Sejarah Papua', 'author' => 'Jan Pouwer', 'year' => 1999],
                ['judul' => 'Papua Road Map', 'author' => 'Muridan S. Widjojo', 'year' => 2009],
                ['judul' => 'Jayapura Tempo Doeloe', 'author' => 'Tim Sejarah', 'year' => 2015],
            ],
        ];

        // Generate books for major categories
        foreach ($booksPerCategory as $categoryName => $books) {
            $category = Category::where('nama', $categoryName)->first();
            
            foreach ($books as $bookData) {
                Buku::create([
                    'uuid' => Str::uuid(),
                    'judul' => $bookData['judul'],
                    'author' => $bookData['author'],
                    'publisher' => 'Penerbit Umum',
                    'year' => $bookData['year'],
                    'stock' => rand(5, 20),
                    'denda_per_hari' => 1000,
                    'deskripsi' => 'Buku kategori ' . $categoryName . '. ' . $bookData['judul'] . ' adalah salah satu karya penting dalam literatur Indonesia.',
                    'slug' => Str::slug($bookData['judul']),
                    'category_id' => [$category->id],
                    'banner' => null,
                    'gdrive_link' => null
                ]);
            }
        }

        // Generate 10 books for remaining categories
        $remainingCategories = array_diff($categories, array_keys($booksPerCategory));
        
        foreach ($remainingCategories as $categoryName) {
            $category = Category::where('nama', $categoryName)->first();
            
            for ($i = 1; $i <= 10; $i++) {
                Buku::create([
                    'uuid' => Str::uuid(),
                    'judul' => 'Buku ' . $categoryName . ' #' . $i,
                    'author' => 'Penulis ' . $categoryName . ' ' . $i,
                    'publisher' => 'Penerbit ' . $categoryName,
                    'year' => rand(2010, 2024),
                    'stock' => rand(5, 20),
                    'denda_per_hari' => 1000,
                    'deskripsi' => 'Ini adalah buku ke-' . $i . ' dalam kategori ' . $categoryName . '. Buku ini membahas berbagai topik menarik seputar ' . strtolower($categoryName) . '.',
                    'slug' => Str::slug($categoryName . '-' . $i),
                    'category_id' => [$category->id],
                    'banner' => null,
                    'gdrive_link' => null
                ]);
            }
        }
    }
}