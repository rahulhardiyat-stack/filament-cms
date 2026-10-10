<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $teknologi = Category::where('slug', 'teknologi')->first();
        $bisnis = Category::where('slug', 'bisnis')->first();
        $desain = Category::where('slug', 'desain')->first();
        $inspirasi = Category::where('slug', 'inspirasi')->first();
        $tutorial = Category::where('slug', 'tutorial')->first();

        $ahmad = Author::where('slug', 'ahmad-rizki')->first();
        $dewi = Author::where('slug', 'dewi-kartika')->first();
        $budi = Author::where('slug', 'budi-santoso')->first();
        $sari = Author::where('slug', 'sari-indah')->first();
        $eko = Author::where('slug', 'eko-prasetyo')->first();
        $fitri = Author::where('slug', 'fitri-amaliah')->first();

        $articles = [
            [
                'category_id' => $teknologi->id,
                'author_id' => $ahmad->id,
                'title' => 'Masa Depan Artificial Intelligence dalam Kehidupan Sehari-hari',
                'excerpt' => 'Bagaimana AI mengubah cara kita berinteraksi dengan teknologi dan menciptakan peluang baru di berbagai industri modern saat ini.',
                'content' => $this->getAIArticleContent(),
                'read_time' => 12,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
                'views_count' => 2847
            ],
            [
                'category_id' => $tutorial->id,
                'author_id' => $dewi->id,
                'title' => 'Memulai dengan React Hooks',
                'excerpt' => 'Panduan lengkap untuk memahami dan menggunakan React Hooks dalam project modern.',
                'content' => $this->getReactHooksContent(),
                'read_time' => 15,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(10),
                'views_count' => 1523
            ],
            [
                'category_id' => $bisnis->id,
                'author_id' => $eko->id,
                'title' => 'Strategi Marketing Digital 2025',
                'excerpt' => 'Tren terbaru dalam dunia marketing digital yang perlu Anda ketahui tahun ini.',
                'content' => $this->getMarketingContent(),
                'read_time' => 11,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(12),
                'views_count' => 1876
            ],
            [
                'category_id' => $inspirasi->id,
                'author_id' => $fitri->id,
                'title' => 'Kisah Sukses Startup Indonesia',
                'excerpt' => 'Belajar dari perjalanan entrepreneur lokal yang berhasil membangun bisnis global.',
                'content' => $this->getStartupContent(),
                'read_time' => 9,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(15),
                'views_count' => 1342
            ],
            [
                'category_id' => $desain->id,
                'author_id' => $sari->id,
                'title' => 'Prinsip Desain UI/UX Modern 2025',
                'excerpt' => 'Teknik dan prinsip desain terbaru untuk menciptakan pengalaman pengguna yang optimal.',
                'content' => $this->getDesignContent(),
                'read_time' => 8,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(20),
                'views_count' => 1654
            ],
            [
                'category_id' => $teknologi->id,
                'author_id' => $budi->id,
                'title' => 'Pengenalan kepada Web3 dan Blockchain',
                'excerpt' => 'Memahami dasar-dasar teknologi blockchain dan bagaimana Web3 mengubah internet.',
                'content' => $this->getBlockchainContent(),
                'read_time' => 13,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(18),
                'views_count' => 2134
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }

    private function getAIArticleContent()
    {
        return '<p>Artificial Intelligence telah menjadi bagian integral dari kehidupan modern kita. Dari asisten virtual di smartphone hingga rekomendasi konten di platform streaming, AI mengubah cara kita berinteraksi dengan teknologi setiap hari.</p>

<p>Perkembangan teknologi AI dalam beberapa tahun terakhir sungguh menakjubkan. Yang dulunya hanya ada dalam film fiksi ilmiah, kini menjadi kenyataan yang kita gunakan sehari-hari. Machine learning dan deep learning telah membuka kemungkinan yang sebelumnya tidak terbayangkan.</p>

<h2>Transformasi di Berbagai Industri</h2>

<p>Industri kesehatan mengalami revolusi besar berkat AI. Sistem diagnosis berbasis AI dapat menganalisis hasil tes medis dengan akurasi tinggi, membantu dokter mendeteksi penyakit lebih cepat. Dalam beberapa kasus, AI bahkan dapat memprediksi risiko penyakit sebelum gejala muncul.</p>

<p>Di sektor finansial, AI digunakan untuk mendeteksi fraud, menganalisis risiko investasi, dan memberikan layanan customer service 24/7 melalui chatbot cerdas.</p>';
    }

    private function getReactHooksContent()
    {
        return '<p>React Hooks adalah fitur yang diperkenalkan di React 16.8 yang memungkinkan kita menggunakan state dan fitur React lainnya tanpa menulis class component.</p>

<h2>Kenapa Menggunakan Hooks?</h2>

<p>Hooks membuat kode lebih mudah dibaca dan di-maintain. Dengan hooks, kita bisa membagi logic yang complex menjadi fungsi-fungsi kecil yang reusable.</p>';
    }

    private function getMarketingContent()
    {
        return '<p>Digital marketing terus berkembang dengan pesat. Tahun 2025 membawa tren-tren baru yang perlu diperhatikan oleh para marketer.</p>

<h2>Personalisasi adalah Kunci</h2>

<p>Konsumen modern mengharapkan pengalaman yang dipersonalisasi. Gunakan data analytics untuk memahami audience Anda lebih dalam.</p>';
    }

    private function getStartupContent()
    {
        return '<p>Membangun startup bukanlah perjalanan yang mudah, namun kisah-kisah sukses dari entrepreneur lokal membuktikan bahwa dengan kerja keras dan strategi yang tepat, kesuksesan bisa diraih.</p>

<h2>Dari Ide ke Eksekusi</h2>

<p>Setiap startup sukses dimulai dari ide yang sederhana namun powerful. Yang membedakan adalah eksekusi yang konsisten.</p>';
    }

    private function getDesignContent()
    {
        return '<p>Desain UI/UX yang baik tidak hanya tentang estetika, tetapi juga tentang bagaimana pengguna berinteraksi dengan produk Anda.</p>

<h2>Prinsip Dasar UI/UX</h2>

<p>Kesederhanaan adalah kunci. Interface yang terlalu rumit akan membingungkan pengguna dan menurunkan conversion rate.</p>';
    }

    private function getBlockchainContent()
    {
        return '<p>Blockchain adalah teknologi yang mendasari cryptocurrency, namun aplikasinya jauh lebih luas dari itu.</p>

<h2>Apa itu Blockchain?</h2>

<p>Blockchain adalah distributed ledger technology yang mencatat transaksi secara transparan dan aman.</p>';
    }
}