@extends('layouts.app')

@section('content')
  <div class="py-10 px-4 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-center">Liên hệ với chúng tôi</h1>

    <div class="max-w-xl mx-auto">
      <livewire:contact-form />
    </div>
  </div>
@endsection
