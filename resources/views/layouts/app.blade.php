<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ICCFB 2025</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @vite('resources/css/app.css') {{-- CSS của Tailwind --}}
  @wireUiScripts {{-- JS của WireUI --}}
  @livewireStyles {{-- Style của Livewire --}}
</head>

<body>
  {{-- Livewire Scripts nên để ở cuối body --}}
  <div>
    <div>
      @include('layouts.header')
    </div>

    <div class="w-full bg-white">
      <div class="max-w-[1200px] mx-auto bg-slate-100 min-h-[700px]">
        @yield('content')
      </div>
    </div>

    <div>
      {{-- @include('layouts.footer') --}}
    </div>
  </div>

  @livewireScripts
</body>
@vite('resources/js/app.js')

</html>
