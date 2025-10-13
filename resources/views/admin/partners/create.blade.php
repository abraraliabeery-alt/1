@extends('layouts.admin')

@section('admin')
  <h1 style="margin-top:0">شريك جديد</h1>
  @include('admin.partners._form', [
    'action' => route('admin.partners.store'),
    'method' => 'POST',
    'partner' => null,
  ])
@endsection
