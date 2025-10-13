@extends('layouts.admin')

@section('admin')
  <div class="row-between" style="align-items:center; gap:12px">
    <h1 style="margin-top:0">تعديل شريك: {{ $partner->name }}</h1>
    <a class="btn btn-outline" href="{{ route('admin.partners.index') }}">← رجوع</a>
  </div>

  @include('admin.partners._form', [
    'action' => route('admin.partners.update', $partner),
    'method' => 'PUT',
    'partner' => $partner,
  ])
@endsection
