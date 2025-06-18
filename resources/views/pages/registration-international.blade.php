@extends('layouts.app')

@section('content')
  <div class="py-16 px-5">
    <div class="mb-10 text-center">
      <h1 class="text-3xl font-bold">REGISTRATION - INTERNATIONAL PARTICIPANT</h1>
      <div class="italic">
        Please complete the following details to submit your request.
      </div>
    </div>
    <div>
      @include('components.registration-international-form')
    </div>
  </div>
  @vite('resources/js/registration-international-form.js')
@endsection
