@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">البحث</h1>

    <form method="GET" action="{{ route('search') }}" class="mb-6 flex gap-2">
        <input type="text" name="q" value="{{ old('q', $q) }}" placeholder="ابحث هنا..." class="flex-1 border rounded px-3 py-2" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">بحث</button>
    </form>

    @if($error)
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $error }}</div>
    @endif

    @if($q && !$error)
        @if($info)
            <div class="text-sm text-gray-600 mb-4">حوالي {{ $info['totalResults'] ?? '?' }} نتيجة عن "{{ $q }}"</div>
        @endif

        @if(!empty($items))
            <ul class="space-y-4">
                @foreach($items as $item)
                    <li class="border-b pb-4">
                        <a href="{{ $item['link'] ?? '#' }}" target="_blank" rel="noopener" class="text-blue-700 hover:underline text-lg font-semibold">
                            {{ $item['title'] ?? 'بدون عنوان' }}
                        </a>
                        @if(!empty($item['displayLink']))
                            <div class="text-xs text-gray-500">{{ $item['displayLink'] }}</div>
                        @endif
                        @if(!empty($item['snippet']))
                            <p class="text-gray-800 mt-1">{{ $item['snippet'] }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-gray-600">لا توجد نتائج.</div>
        @endif

        <div class="flex items-center gap-2 mt-6">
            @if($prevPage)
                <a href="{{ route('search', ['q' => $q, 'page' => $prevPage]) }}" class="px-3 py-2 border rounded">السابق</a>
            @endif
            @if($nextPage)
                <a href="{{ route('search', ['q' => $q, 'page' => $nextPage]) }}" class="px-3 py-2 border rounded">التالي</a>
            @endif
        </div>
    @endif
</div>
@endsection
