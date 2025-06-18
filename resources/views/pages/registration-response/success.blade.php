@extends('layouts.app')

@section('content')
  <div class="max-w-xl mx-auto text-center py-12 px-4 sm:px-6 lg:px-8">
    <h3 class="text-2xl font-semibold text-green-600">Successful payment</h3>
    <p class="mt-4 text-lg font-bold text-gray-800">THANK YOU, YOUR PAYMENT HAS BEEN PROCESSED SUCCESSFULLY</p>
    <p class="mt-2 text-gray-600">
      You will be receiving an email shortly to confirm the transaction.<br>
      Please check your Spam mail to ensure you will receive your Receipt.
    </p>
    <p class="mt-4 text-gray-600">
      If you require additional assistance, please contact us at
      <a href="mailto:iccfb@hcmut.edu.vn" class="text-blue-600 underline">iccfb@hcmut.edu.vn</a> &
      <a href="mailto:dh.qtl@hoabinh-group.com" class="text-blue-600 underline">dh.qtl@hoabinh-group.com</a>.
    </p>
  </div>
@endsection
