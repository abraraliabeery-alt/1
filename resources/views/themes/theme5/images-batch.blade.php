@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">استخراج صور المنتجات من ملف نصي</h1>

    <form action="{{ route('images.batch.handle') }}" method="POST" enctype="multipart/form-data" class="space-y-4 border p-4 rounded mb-8">
        @csrf
        <div>
            <label class="block mb-1">ملف الأسماء (.txt) — سطر لكل اسم</label>
            <input type="file" name="names" accept=".txt" class="border rounded px-3 py-2 w-full" required />
            @error('names')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="block mb-1">عدد الصور لكل اسم (1–3)</label>
            <input type="number" name="num" value="{{ old('num', $num ?? 1) }}" min="1" max="3" class="border rounded px-3 py-2 w-24" />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">بدء الاستخراج</button>
    </form>

    @isset($results)
        <div class="space-y-8">
            @foreach($results as $row)
                <div>
                    <h2 class="font-semibold mb-2">{{ $row['name'] }}</h2>
                    @if(!empty($row['images']))
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($row['images'] as $img)
                                <div class="border rounded p-2">
                                    @if(!empty($img['thumbnail']))
                                        <a href="{{ $img['link'] }}" target="_blank" rel="noopener">
                                            <img src="{{ $img['thumbnail'] }}" alt="{{ $img['title'] ?? '' }}" class="w-full h-40 object-cover" />
                                        </a>
                                    @endif
                                    <div class="text-sm mt-2 truncate">
                                        <a class="text-blue-700 hover:underline" href="{{ $img['link'] }}" target="_blank" rel="noopener">رابط الصورة</a>
                                        @if(!empty($img['contextLink']))
                                            · <a class="text-blue-700 hover:underline" href="{{ $img['contextLink'] }}" target="_blank" rel="noopener">المصدر</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-gray-600">لا توجد صور.</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endisset
</div>
@endsection
