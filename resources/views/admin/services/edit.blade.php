@extends('layouts.admin')

@section('admin')
  <div class="row-between" style="align-items:center; gap:12px">
    <h1 style="margin-top:0">تعديل خدمة: {{ $service->title }}</h1>
    <a class="btn btn-outline" href="{{ route('admin.services.index') }}">← رجوع</a>
  </div>

  @include('admin.services._form', [
    'action' => route('admin.services.update', $service),
    'method' => 'PUT',
    'service' => $service,
  ])
@endsection
