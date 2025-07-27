@extends('layouts.app')

@section('title', 'Login - Philocalist')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-spray-can text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Philocalist</h2>
                <p class="mt-2 text-gray-600">Masuk ke dashboard admin</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 {{ $errors->has('email') ? 'border-red-300' : '' }}"
                            placeholder="admin@philocalist.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 {{ $errors->has('password') ? 'border-red-300' : '' }}"
                            placeholder="Masukkan password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember" type="checkbox"
                                class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-pink-600 hover:text-pink-500">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <div class="flex">
                                <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-2"></i>
                                <div class="text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Login Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk ke Dashboard
                        </button>
                    </div>

                    <!-- Back to Website -->
                    <div class="text-center">
                        <a href="{{ route('home') }}" 
                            class="text-sm text-gray-600 hover:text-pink-600 transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali ke Website
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom focus styles */
        .focus\:ring-pink-500:focus {
            --tw-ring-color: rgb(236 72 153 / 0.5);
        }
        
        /* Smooth transitions */
        input {
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        /* Button hover animation */
        button[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(236, 72, 153, 0.3);
        }
        
        button[type="submit"] {
            transition: all 0.2s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-hide error messages after 8 seconds
        setTimeout(() => {
            const errorAlert = document.querySelector('.bg-red-50');
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                errorAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => errorAlert.remove(), 300);
            }
        }, 8000);

        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            button.disabled = true;
            
            // Reset after 5 seconds if needed (fallback)
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 5000);
        });
    </script>
@endpush