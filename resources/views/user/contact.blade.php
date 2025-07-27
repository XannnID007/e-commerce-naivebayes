@extends('layouts.app')

@section('title', 'Hubungi Kami - Philocalist')
@section('description', 'Hubungi tim customer service Philocalist untuk pertanyaan seputar produk parfum dan layanan kami')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-pink-50 via-white to-purple-50 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <i class="fas fa-comments text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Hubungi Kami</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Tim customer service kami siap membantu Anda menemukan parfum yang tepat dan menjawab pertanyaan seputar produk kami
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                    <form class="space-y-6" method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap *
                                </label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email *
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors"
                                    placeholder="nama@email.com">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors"
                                placeholder="+62 812-3456-7890">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                Subjek *
                            </label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors">
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
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                Pesan *
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors resize-none"
                                placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input id="newsletter" name="newsletter" type="checkbox"
                                class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <label for="newsletter" class="ml-3 block text-sm text-gray-700">
                                Saya ingin menerima newsletter dan update produk terbaru
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-pink-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Contact Cards -->
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-pink-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat Toko</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        Jl. Blok Cikendal No. 66, RT 06/RW 05<br>
                                        Kelurahan Melong, Kecamatan Cimahi Selatan<br>
                                        Kota Cimahi, Jawa Barat 40534
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                                    <p class="text-gray-600">
                                        <a href="tel:+6281234567890" class="hover:text-blue-600 transition-colors">+62 812-3456-7890</a><br>
                                        <span class="text-sm text-gray-500">Senin - Sabtu: 09:00 - 18:00</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                                    <p class="text-gray-600">
                                        <a href="mailto:info@philocalist.com" class="hover:text-green-600 transition-colors">info@philocalist.com</a><br>
                                        <a href="mailto:cs@philocalist.com" class="hover:text-green-600 transition-colors">cs@philocalist.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-share-alt text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Media Sosial</h3>
                                    <div class="flex space-x-4">
                                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="#" class="w-10 h-10 bg-pink-600 rounded-lg flex items-center justify-center text-white hover:bg-pink-700 transition-colors">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="#" class="w-10 h-10 bg-blue-400 rounded-lg flex items-center justify-center text-white hover:bg-blue-500 transition-colors">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#" class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white hover:bg-green-700 transition-colors">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-lg text-gray-600">Temukan jawaban untuk pertanyaan umum seputar produk dan layanan kami</p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900">Bagaimana sistem AI mengklasifikasikan parfum?</span>
                        <i class="fas fa-chevron-down transform transition-transform duration-200"
                            :class="openFaq === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">
                            Sistem kami menggunakan algoritma Naive Bayes yang menganalisis deskripsi produk, top notes, middle notes, dan base notes untuk mengklasifikasikan parfum ke dalam 8 kategori aroma utama dengan tingkat kepercayaan yang tinggi.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900">Apakah semua produk tersedia untuk dipesan?</span>
                        <i class="fas fa-chevron-down transform transition-transform duration-200"
                            :class="openFaq === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">
                            Ketersediaan produk ditampilkan secara real-time di website. Anda dapat melihat status stok pada halaman detail produk. Untuk pemesanan, silakan hubungi customer service kami.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900">Bagaimana cara memilih parfum yang sesuai?</span>
                        <i class="fas fa-chevron-down transform transition-transform duration-200"
                            :class="openFaq === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">
                            Anda dapat menggunakan filter kategori di halaman produk untuk menemukan parfum berdasarkan jenis aroma yang Anda sukai. Tim customer service kami juga dapat memberikan rekomendasi personal.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900">Berapa lama pengiriman produk?</span>
                        <i class="fas fa-chevron-down transform transition-transform duration-200"
                            :class="openFaq === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 4" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">
                            Pengiriman biasanya memakan waktu 2-5 hari kerja untuk area Jawa Barat dan sekitarnya, dan 3-7 hari kerja untuk area lainnya di Indonesia. Kami akan memberikan nomor resi untuk tracking.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Message Modal -->
    <div id="successModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Pesan Terkirim!</h3>
                <p class="text-gray-600 mb-6">
                    Terima kasih! Pesan Anda telah dikirim. Tim customer service kami akan segera menghubungi Anda dalam 1x24 jam.
                </p>
                <button onclick="closeSuccessModal()"
                    class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-pink-700 hover:to-purple-700 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form submission handling
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show success modal
            document.getElementById('successModal').classList.remove('hidden');

            // Reset form
            this.reset();
        });

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSuccessModal();
            }
        });

        // Smooth animations for form elements
        document.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .focused {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush