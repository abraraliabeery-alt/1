@extends('layouts.admin')

@section('admin')
  <h1 style="margin-top:0">خدمة جديدة</h1>
  @include('admin.services._form', [
    'action' => route('admin.services.store'),
    'method' => 'POST',
    'service' => null,
  ])
@endsection
