<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
     public function authorize()
     {
          return auth()->user() && auth()->user()->isAdmin();
     }

     public function rules()
     {
          $rules = [
               'nama' => 'required|string|max:255',
               'deskripsi' => 'required|string',
               'harga' => 'required|numeric|min:0',
               'konsentrasi' => 'required|in:EDC,EDT,EDP',
               'top_notes' => 'nullable|string|max:500',
               'middle_notes' => 'nullable|string|max:500',
               'base_notes' => 'nullable|string|max:500',
               'stok' => 'required|integer|min:0',
               'aktif' => 'boolean'
          ];

          if ($this->isMethod('POST')) {
               $rules['gambar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
          } else {
               $rules['gambar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
               $rules['category_id'] = 'required|exists:categories,id';
          }

          return $rules;
     }

     public function messages()
     {
          return [
               'nama.required' => 'Nama produk wajib diisi',
               'deskripsi.required' => 'Deskripsi produk wajib diisi',
               'harga.required' => 'Harga produk wajib diisi',
               'harga.numeric' => 'Harga harus berupa angka',
               'konsentrasi.required' => 'Konsentrasi parfum wajib dipilih',
               'konsentrasi.in' => 'Konsentrasi parfum tidak valid',
               'stok.required' => 'Stok produk wajib diisi',
               'stok.integer' => 'Stok harus berupa angka',
               'gambar.image' => 'File harus berupa gambar',
               'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
               'gambar.max' => 'Ukuran gambar maksimal 2MB'
          ];
     }
}
