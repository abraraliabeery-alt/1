@extends('layouts.admin')

@section('admin')
  <div class="row-between" style="align-items:center; gap:12px">
    <h1 style="margin:0">تعديل سؤال: {{ $faq->question }}</h1>
    <a class="btn btn-outline" href="{{ route('admin.faqs.index') }}">← رجوع</a>
  </div>

  @include('admin.faqs._form', [
    'action' => route('admin.faqs.update', $faq),
    'method' => 'PUT',
    'faq' => $faq,
  ])
@endsection
