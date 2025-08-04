@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail User')
@section('page-description', 'Informasi lengkap untuk user ' . $user->name)

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informasi User</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Alamat Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="mailto:{{ $user->email }}"
                                class="text-pink-600 hover:underline">{{ $user->email }}</a>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Peran (Role)</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role_color }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status_color }}">
                                {{ $user->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d F Y') }}</dd>
                    </div>
                </dl>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 text-sm">
                    <i class="fas fa-edit mr-2"></i>Edit User
                </a>
            </div>
        </div>
    </div>
@endsection
