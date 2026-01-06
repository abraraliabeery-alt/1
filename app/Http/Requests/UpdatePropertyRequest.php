<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'city' => ['required','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'type' => ['required','string','max:50'],
            'price' => ['required','integer','min:0'],
            'area' => ['nullable','integer','min:0'],
            'bedrooms' => ['nullable','integer','min:0','max:50'],
            'bathrooms' => ['nullable','integer','min:0','max:50'],
            'status' => ['nullable','string','max:100'],
            'is_featured' => ['sometimes','boolean'],
            'description' => ['nullable','string'],
            'location_url' => ['nullable','url','max:2048'],
            'cover_image' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:5120'],
            'gallery_images' => ['nullable','array'],
            'gallery_images.*' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:5120'],
            'video_file' => ['nullable','file','mimetypes:video/mp4,video/webm,video/ogg','max:51200'],
            'video_url' => ['nullable','url','max:2048'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $hasFile = $this->hasFile('video_file');
            $hasUrl = filled($this->input('video_url'));
            if ($hasFile && $hasUrl) {
                $v->errors()->add('video_file', __('يرجى اختيار مصدر واحد للفيديو: إما ملف أو رابط يوتيوب'));
            }

            if ($this->hasFile('gallery_images')) {
                $files = $this->file('gallery_images') ?? [];
                $count = is_array($files) ? count($files) : 0;
                $maxUploads = (int) (ini_get('max_file_uploads') ?: 0);
                if ($maxUploads > 0 && $count > $maxUploads) {
                    $v->errors()->add('gallery_images', __('عدد صور المعرض كبير. حد السيرفر الحالي لعدد الملفات في الرفع الواحد هو :max، يرجى رفع الصور على دفعات أو زيادة إعداد max_file_uploads في PHP.', ['max' => $maxUploads]));
                }
            }
        });
    }
}
