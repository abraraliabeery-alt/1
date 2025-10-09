@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      {{-- Flash messages --}}
      @if(session('ok'))
        <div class="card" style="margin-bottom:12px; border-color:#22c55e"><strong>تم:</strong> {{ session('ok') }}</div>
      @endif

      <nav style="margin-bottom:12px"><a href="{{ route('projects.index') }}">← الرجوع لقائمة المشاريع</a></nav>

      <h1 style="margin-bottom:6px">{{ $project->title }}</h1>
      <p style="color:var(--muted)">
        @if($project->client) عميل: {{ $project->client }} | @endif
        @if($project->city) المدينة: {{ $project->city }} | @endif
        الحالة: {{ $project->status }}
      </p>

      <div class="grid-2" style="margin-top:18px">
        <div>
          @if($project->cover_image)
            <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" style="border-radius:14px; width:100%; height:auto" />
          @else
            <div class="illustration"></div>
          @endif
          @if(is_array($project->gallery) && count($project->gallery))
            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:8px; margin-top:10px">
              @foreach($project->gallery as $g)
                <img src="{{ $g }}" alt="{{ $project->title }}" style="border-radius:10px; width:100%; height:120px; object-fit:cover" />
              @endforeach
            </div>
          @endif
        </div>
        <div>
          <h3>الوصف</h3>
          <p>{{ $project->description }}</p>

          <div class="card" style="margin-top:16px">
            <h4>معلومات</h4>
            <ul style="margin:8px 0 0 0; padding-inline-start:18px; color:var(--muted)">
              @if($project->category)<li>التصنيف: {{ $project->category }}</li>@endif
              @if($project->started_at)<li>البداية: {{ $project->started_at }}</li>@endif
              @if($project->finished_at)<li>الانتهاء: {{ $project->finished_at }}</li>@endif
              <li>الحالة: {{ $project->status }}</li>
            </ul>
          </div>

          <div class="cta" style="margin-top:16px">
            <a class="btn btn-primary" href="#contact">ارسل لنا مشروعاً مماثلاً</a>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
