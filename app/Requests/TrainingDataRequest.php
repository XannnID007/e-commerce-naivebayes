<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingDataRequest extends FormRequest
{
     public function authorize()
     {
          return auth()->user() && auth()->user()->isAdmin();
     }

     public function rules()
     {
          return [
               'deskripsi' => 'required|string',
               'top_notes' => 'nullable|string|max:500',
               'middle_notes' => 'nullable|string|max:500',
               'base_notes' => 'nullable|string|max:500',
               'category_id' => 'required|exists:categories,id'
          ];
     }

     public function messages()
     {
          return [
               'deskripsi.required' => 'Deskripsi wajib diisi',
               'category_id.required' => 'Kategori wajib dipilih',
               'category_id.exists' => 'Kategori tidak valid'
          ];
     }
}
