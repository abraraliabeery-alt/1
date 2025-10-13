@extends('layouts.admin')

@section('admin')
  <h1 style="margin-top:0">سؤال شائع جديد</h1>
  @include('admin.faqs._form', [
    'action' => route('admin.faqs.store'),
    'method' => 'POST',
    'faq' => $faq ?? null,
  ])
@endsection
