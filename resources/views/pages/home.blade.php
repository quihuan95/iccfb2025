@extends('layouts.app')

@section('content')
  <div class="flex flex-col items-center justify-center px-4 py-20">
    <h2 class="text-center text-gray-800 text-sm font-medium mb-8">Please choose your category:</h2>

    <div class="flex gap-12">
      {{-- International Participant --}}
      <a href="{{ route('registration.form.international') }}"
        class="bg-lime-500 hover:bg-lime-600 text-white font-bold py-10 px-12 rounded-md shadow-md transition-all duration-300 text-center w-64 text-sm uppercase tracking-wide">
        International<br>Participant
      </a>

      {{-- Vietnamese Participant --}}
      <a href="{{ route('registration.form.vietnamese') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-10 px-12 rounded-md shadow-md transition-all duration-300 text-center w-64 text-sm uppercase tracking-wide">
        Vietnamese<br>Participant
      </a>
    </div>
  </div>
@endsection
