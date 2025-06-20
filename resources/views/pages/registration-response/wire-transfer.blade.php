@extends('layouts.app')

@section('content')
  <div class="max-w-[1200px] mx-auto py-12 px-6 text-gray-800 font-sans space-y-4">
    <p>Thank you for registering for the <strong>7<sup>th</sup> International Conference on Chemical Engineering, Food and Bio Technology (ICCFB 2025)</strong>.</p>

    <p>
      Your registration ID is
      <strong class="text-blue-600">{{ $registration['registration_code'] ?? 'XXXX' }}</strong>.
      Please keep the registration number for your records.
      The registration number is required for all communications with ICCFB 2025 regarding this registration.
    </p>

    <p>
      Please transfer the conference fee -
      <strong
        class="text-green-600">{{ ($registration['display_conference']->currency ?? 'USD') === 'VND'
            ? 'VND ' . number_format($registration['display_conference']->fee, 0, ',', '.')
            : ($registration['display_conference']->currency ?? 'USD') . ' ' . number_format($registration['display_conference']->fee, 2) }}</strong>
      to the following bank:
    </p>

    <div class="bg-gray-100 p-4 rounded-md border border-gray-200">
      <p><strong>Account Holder:</strong> HOA BINH INTERNATIONAL TOUR CO., TD</p>
      <p><strong>Account Number:</strong> {{ $registration['display_conference']->currency == 'USD' ? '087 214 274 7422 (USD)' : '852 805 141 4755 (VND)' }} </p>
      <p><strong>Bank:</strong> Military Commercial Joint Stock Bank (MB) – Thang Long Branch</p>
      <p><strong>Bank code:</strong> 0131100620</p>
      <p><strong>SWIFT code:</strong> MSCBVNVX</p>
    </div>

    <p>
      Please indicate, "<strong> {{ $registration['fullname'] ?? 'Full Name' }} – {{ $registration['registration_code'] ?? 'Registration ID' }} paid for ICCFB 2025</strong>" as a
      reference and send proof of bank transfer to
      <a href="mailto:iccfb@hcmut.edu.vn" class="text-blue-600 underline">iccfb@hcmut.edu.vn</a> &
      <a href="mailto:dh.qt1@hoabinh-group.com" class="text-blue-600 underline">dh.qt1@hoabinh-group.com</a>.
    </p>
  </div>
@endsection
