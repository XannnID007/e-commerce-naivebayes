<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
     public function authorize()
     {
          return auth()->user() && auth()->user()->isAdmin();
     }

     public function rules()
     {
          $categoryId = $this->route('category') ? $this->route('category')->id : null;

          return [
               'nama' => 'required|string|max:255|unique:categories,nama,' . $categoryId,
               'deskripsi' => 'nullable|string|max:1000',
               'icon' => 'nullable|string|max:100'
          ];
     }

     public function messages()
     {
          return [
               'nama.required' => 'Nama kategori wajib diisi',
               'nama.unique' => 'Nama kategori sudah digunakan',
               'deskripsi.max' => 'Deskripsi maksimal 1000 karakter',
               'icon.max' => 'Kelas icon maksimal 100 karakter'
          ];
     }
}
