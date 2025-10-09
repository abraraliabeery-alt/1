@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        {{ $slot ?? '' }}
      </div>
    </div>
  </main>
@endsection
