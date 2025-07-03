@extends('layouts.app')

@section('content')
  <div class="flex flex-col items-center justify-center px-4 py-10">
    <p class="text-red-600 italic mb-4">
      * Please note that the ICCFB2025 Organizing Committee is NOT involved in the bookings listed below. Any inquiries or claims should be directed to HOA BINH GROUP at
      dh.qt2@hoabinh-group.com. Please do not contact the ICCFB2025 Organizing Committee regarding these matters.
    </p>

    <p class="text-red-600 italic mb-8">
      Booking through HOA BINH GROUP is just one of many options available in Ho Chi Minh City. ICCFB2025 Organizing Committee neither requires nor endorses the use of this service.
    </p>

    <h1 class="text-3xl font-bold text-center mb-1">SAIGON PRINCE HOTEL</h1>
    <p class="text-center italic mb-2">Conference venue</p>
    <p class="text-center mb-8">59-73 Nguyen Hue Boulevard, District 1, Ho Chi Minh City, Vietnam</p>

    <div class="overflow-x-auto mb-8">
      <table class="min-w-full border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2 text-center">Room type</th>
            <th class="border border-gray-300 px-4 py-2 text-center">Rate via Agoda</th>
            <th class="border border-gray-300 px-4 py-2 text-center">Rate via HBG</th>
            <th class="border border-gray-300 px-4 py-2 text-center"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <strong>PREMIER Double - 28sqm</strong><br>
              01 King bed for maximum 02 occupancies
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              2.560.000++ VND/room/night
            </td>
            <td class="border border-gray-300 px-4 py-2 text-red-600 font-semibold text-center">
              2.450.000++ VND/room/night<br>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <a href="https://bookandpay.vn/book-hotels/66?num=1" class="text-blue-600 font-bold underline">BOOK NOW</a>
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <strong>PREMIER Twin - 28sqm</strong><br>
              02 Single beds for maximum 02 occupancies
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              2.560.000++ VND/room/night
            </td>
            <td class="border border-gray-300 px-4 py-2 text-red-600 font-semibold text-center">
              2.450.000++ VND/room/night<br>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <a href="https://bookandpay.vn/book-hotels/66?num=2" class="text-blue-600 font-bold underline">BOOK NOW</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="bg-blue-100 p-4 border-l-4 border-blue-500">
      <h3 class="font-bold mb-2">USEFUL INFORMATION:</h3>
      <ul class="list-disc pl-5 space-y-2">
        <li>All the rates above include breakfast, in-room Wi-Fi, two bottles of mineral water per room per day, and complimentary access to the gym and pool. A 5% service charge and
          8% VAT are not included.</li>
        <li>For urgent help with booking issues or additional directions, please feel free to contact Dustin at: <br> Mobile/WhatsApp: +84 939 555 833 | Email:
          dh.qt2@hoabinh-group.com
        </li>
      </ul>
    </div>
  </div>
@endsection
