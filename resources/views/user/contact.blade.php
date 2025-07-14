@extends('layouts.app')

@section('title', 'Hubungi Kami - Philocalist')
@section('description', 'Hubungi tim customer service Philocalist untuk pertanyaan seputar produk parfum dan layanan
    kami')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-pink-50 to-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Tim customer service kami siap membantu Anda menemukan parfum yang tepat dan menjawab pertanyaan
                        seputar produk kami
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Contact Cards -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Address -->
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-pink-500">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-pink-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat Toko</h3>
                                    <p class="text-gray-600">
                                        Jl. Blok Cikendal No. 66, RT 06/RW 05<br>
                                        Kelurahan Melong, Kecamatan Cimahi Selatan<br>
                                        Kota Cimahi, Jawa Barat 40534
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                                    <p class="text-gray-600">
                                        <a href="tel:+6281234567890" class="hover:text-blue-600">+62 812-3456-7890</a><br>
                                        <span class="text-sm text-gray-500">Senin - Sabtu: 09:00 - 18:00</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                                    <p class="text-gray-600">
                                        <a href="mailto:info@philocalist.com"
                                            class="hover:text-green-600">info@philocalist.com</a><br>
                                        <a href="mailto:cs@philocalist.com"
                                            class="hover:text-green-600">cs@philocalist.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-share-alt text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Media Sosial</h3>
                                    <div class="flex space-x-3">
                                        <a href="#" class="text-gray-400 hover:text-blue-600">
                                            <i class="fab fa-facebook-f text-lg"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-pink-600">
                                            <i class="fab fa-instagram text-lg"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-blue-400">
                                            <i class="fab fa-twitter text-lg"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-green-600">
                                            <i class="fab fa-whatsapp text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                            <form class="space-y-6" method="POST" action="{{ route('contact') }}">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Lengkap *
                                        </label>
                                        <input type="text" id="name" name="name" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                            placeholder="Masukkan nama lengkap Anda">
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email *
                                        </label>
                                        <input type="email" id="email" name="email" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                            placeholder="nama@email.com">
                                    </div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="tel" id="phone" name="phone"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                        placeholder="+62 812-3456-7890">
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                        Subjek *
                                    </label>
                                    <select id="subject" name="subject" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                        <option value="">Pilih subjek pertanyaan</option>
                                        <option value="product-inquiry">Pertanyaan Produk</option>
                                        <option value="order-status">Status Pesanan</option>
                                        <option value="recommendation">Rekomendasi Parfum</option>
                                        <option value="technical-support">Dukungan Teknis</option>
                                        <option value="partnership">Kerjasama</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pesan *
                                    </label>
                                    <textarea id="message" name="message" rows="6" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                        placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."></textarea>
                                </div>

                                <div class="flex items-center">
                                    <input id="newsletter" name="newsletter" type="checkbox"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                                        Saya ingin menerima newsletter dan update produk terbaru
                                    </label>
                                </div>

                                <div>
                                    <button type="submit"
                                        class="w-full bg-pink-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-pink-700 transition-colors">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
                    <p class="text-lg text-gray-600">Temukan jawaban untuk pertanyaan umum seputar produk dan layanan kami
                    </p>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="space-y-4" x-data="{ openFaq: null }">
                        <!-- FAQ 1 -->
                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="openFaq = openFaq === 1 ? null : 1"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                                <span class="font-medium text-gray-900">Bagaimana sistem AI mengklasifikasikan
                                    parfum?</span>
                                <i class="fas fa-chevron-down transform transition-transform"
                                    :class="openFaq === 1 ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                                <p class="text-gray-600">
                                    Sistem kami menggunakan algoritma Naive Bayes yang menganalisis deskripsi produk, top
                                    notes, middle notes, dan base notes untuk mengklasifikasikan parfum ke dalam 8 kategori
                                    aroma utama. AI memberikan tingkat kepercayaan (confidence score) untuk setiap
                                    klasifikasi.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="openFaq = openFaq === 2 ? null : 2"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                                <span class="font-medium text-gray-900">Apakah semua produk tersedia untuk dipesan?</span>
                                <i class="fas fa-chevron-down transform transition-transform"
                                    :class="openFaq === 2 ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                                <p class="text-gray-600">
                                    Ketersediaan produk ditampilkan secara real-time di website. Anda dapat melihat status
                                    stok pada halaman detail produk. Untuk pemesanan, silakan hubungi customer service kami
                                    melalui WhatsApp atau telepon.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="openFaq = openFaq === 3 ? null : 3"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                                <span class="font-medium text-gray-900">Bagaimana cara memilih parfum yang sesuai dengan
                                    kepribadian saya?</span>
                                <i class="fas fa-chevron-down transform transition-transform"
                                    :class="openFaq === 3 ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                                <p class="text-gray-600">
                                    Anda dapat menggunakan filter kategori di halaman produk untuk menemukan parfum
                                    berdasarkan jenis aroma yang Anda sukai. Tim customer service kami juga dapat memberikan
                                    rekomendasi personal berdasarkan preferensi dan kepribadian Anda.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="openFaq = openFaq === 4 ? null : 4"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                                <span class="font-medium text-gray-900">Apakah ada garansi untuk produk parfum?</span>
                                <i class="fas fa-chevron-down transform transition-transform"
                                    :class="openFaq === 4 ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="openFaq === 4" x-collapse class="px-6 pb-4">
                                <p class="text-gray-600">
                                    Semua produk Philocalist memiliki garansi kualitas. Jika Anda tidak puas dengan produk
                                    yang diterima, silakan hubungi customer service dalam 7 hari setelah pembelian untuk
                                    penukaran atau pengembalian dana.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 5 -->
                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="openFaq = openFaq === 5 ? null : 5"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                                <span class="font-medium text-gray-900">Berapa lama pengiriman produk?</span>
                                <i class="fas fa-chevron-down transform transition-transform"
                                    :class="openFaq === 5 ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="openFaq === 5" x-collapse class="px-6 pb-4">
                                <p class="text-gray-600">
                                    Pengiriman biasanya memakan waktu 2-5 hari kerja untuk area Jawa Barat dan sekitarnya,
                                    dan 3-7 hari kerja untuk area lainnya di Indonesia. Kami akan memberikan nomor resi
                                    untuk tracking pengiriman.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section (Optional) -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Toko</h2>
                    <p class="text-lg text-gray-600">Kunjungi toko offline kami untuk konsultasi dan mencoba produk secara
                        langsung</p>
                </div>

                <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center text-gray-600">
                        <i class="fas fa-map-marked-alt text-4xl mb-4"></i>
                        <p class="text-lg font-medium">Peta Lokasi</p>
                        <p class="text-sm">Jl. Blok Cikendal No. 66, Cimahi Selatan</p>
                        <a href="https://maps.google.com" target="_blank"
                            class="mt-2 inline-flex items-center text-pink-600 hover:text-pink-800">
                            <i class="fas fa-external-link-alt mr-1"></i>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form submission handling
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show success message (in real app, this would submit to backend)
            alert(
            'Terima kasih! Pesan Anda telah dikirim. Tim customer service kami akan segera menghubungi Anda.');

            // Reset form
            this.reset();
        });
    </script>
@endpush
