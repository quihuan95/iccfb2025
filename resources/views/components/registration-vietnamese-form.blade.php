<form x-data="registrationForm()" @submit.prevent="submitForm" class="space-y-12 bg-white p-8 rounded-lg shadow-sm">
  <!-- GENERAL INFORMATION -->
  @csrf
  <div class="space-y-8">
    <div class="text-xl font-bold text-blue-800 border-b-2 border-blue-800 pb-2">GENERAL INFORMATION</div>

    <!-- Title -->
    <div class="flex items-start gap-x-6">
      <div class="w-[250px] font-medium text-gray-700 pt-2">Title <span class="text-red-600">*</span>:</div>
      <div class="w-full grid grid-cols-2 md:grid-cols-12 gap-3">
        <template x-for="opt in ['Prof.', 'Dr.', 'Mr.', 'Ms.', 'Other']" :key="opt">
          <label class="inline-flex items-center">
            <input type="radio" :value="opt" x-model="form.title" class="form-checkbox" x-on:change="handleExclusiveSelection(opt)" />
            <span class="ml-2" x-text="opt"></span>
          </label>
        </template>
        <template x-if="form.title.includes('Other')">
          <div class="col-span-7 flex items-center gap-3">
            <label for="other_title" class="text-sm font-medium text-gray-700 whitespace-nowrap">Please specify <span class="text-red-600">*</span>:</label>
            <input id="other_title" x-model="form.other_title" name="other_title" class="border-[.5px] border-gray-300 outline-none px-3 py-1 rounded w-[100px]" />
            <template x-if="errors['other_title']">
              <p class="text-sm text-red-500" x-text="errors['other_title']"></p>
            </template>
          </div>
        </template>
        <template x-if="errors['title']">
          <p class="text-sm text-red-500 col-span-full" x-text="errors['title']"></p>
        </template>
      </div>
    </div>

    <!-- Other fields -->
    <template x-for="field in ['fullname', 'position', 'organization', 'billing_address', 'country', 'phone', 'email']" :key="field">
      <div class="flex items-start gap-x-6 mb-4">
        <label :for="field" class="w-[250px] font-medium text-gray-700 pt-2 capitalize">
          <span x-text="field.replace('_', ' ')"></span>
          <span x-show="['fullname', 'organization', 'billing_address', 'country', 'phone', 'email'].includes(field)" class="text-red-600">*</span>
        </label>
        <div class="w-full">
          <!-- Nếu là country thì dùng select -->
          <template x-if="field === 'country'">
            <select :id="field" x-model="form[field]" :name="field" class="w-full border-[.5px] border-gray-300 outline-none px-3 py-1 rounded">
              <option selected value="VN">Vietnam</option>
            </select>
          </template>

          <!-- Ngược lại dùng input -->
          <template x-if="field !== 'country'">
            <input :id="field" x-model="form[field]" :name="field" class="w-full border-[.5px] border-gray-300 outline-none px-3 py-1 rounded"
              :type="field === 'email' ? 'email' : 'text'" />
          </template>

          <!-- Hiển thị lỗi -->
          <template x-if="errors[field]">
            <p class="text-sm text-red-500 inline-flex" x-text="errors[field]"></p>
          </template>
        </div>
      </div>
    </template>

    <!-- Dietary Requirements -->
    <div class="flex items-center gap-x-6">
      <div class="w-[250px] font-medium text-gray-700 pt-2">
        Dietary Requirements <span class="text-red-600">*</span>:
      </div>
      <div class="flex-1 flex flex-wrap gap-4">
        <template x-for="opt in ['Vegetarian', 'Halal', 'No specific' , 'Other']" :key="opt">
          <label class="inline-flex items-center">
            <input type="radio" :value="opt" x-model="form.dietary_requirement" name="dietary_requirement" class="form-radio" />
            <span class="ml-2" x-text="opt"></span>
          </label>
        </template>
        <template x-if="errors['dietary_requirement']">
          <p class="text-sm text-red-500" x-text="errors['dietary_requirement']"></p>
        </template>
        <template x-if="form.dietary_requirement == 'Other'">
          <div class="col-span-7 flex items-center gap-3">
            <label for="other_dietary_requirement" class="text-sm font-medium text-gray-700 whitespace-nowrap">Please specify <span class="text-red-600">*</span>:</label>
            <input id="other_dietary_requirement" x-model="form.other_dietary_requirement" name="other_dietary_requirement"
              class="border-[.5px] border-gray-300 outline-none px-3 py-1 rounded w-[100px]" />
            <template x-if="errors['other_dietary_requirement']">
              <p class="text-sm text-red-500" x-text="errors['other_dietary_requirement']"></p>
            </template>
          </div>
        </template>
        <template x-if="errors['title']">
          <p class="text-sm text-red-500 col-span-full" x-text="errors['title']"></p>
        </template>
      </div>
    </div>

  </div>

  <!-- CONFERENCE FEE -->
  <div class="space-y-8">
    <div class="text-xl font-bold text-blue-800 border-b-2 border-blue-800 pb-2">CONFERENCE FEE</div>
    <table class="w-full border border-gray-300 text-sm rounded-lg overflow-hidden">
      <thead>
        <tr class="bg-blue-50 text-left">
          <th class="border border-gray-300 px-4 py-3 w-10"></th>
          <th class="border border-gray-300 px-4 py-3 font-semibold text-gray-700">Conference type</th>
          <th class="border border-gray-300 px-4 py-3 font-semibold text-gray-700">Fee</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-3 text-center">
            <input type="radio" id="conf_attendance" x-model="form.conference_type" value="IOP_SCOPUS" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" />
          </td>
          <td class="border border-gray-300 px-4 py-3">Presentation and publication in IOP Conference Series (Scopus)</td>
          <td class="border border-gray-300 px-4 py-3 font-medium">6,000,000 VND</td>
        </tr>
        <tr class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-3 text-center">
            <input type="radio" id="conf_abstract" x-model="form.conference_type" value="Q3_JOURNAL" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" />
          </td>
          <td class="border border-gray-300 px-4 py-3">Presentation and publication in Q3 Journal</td>
          <td class="border border-gray-300 px-4 py-3 font-medium">4,000,000 VND</td>
        </tr>
        <tr class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-3 text-center">
            <input type="radio" id="conf_iop" x-model="form.conference_type" value="ABSTRACT_PRESENT" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" />
          </td>
          <td class="border border-gray-300 px-4 py-3">Abstract only and presentation</td>
          <td class="border border-gray-300 px-4 py-3 font-medium">4,000,000 VND</td>
        </tr>
        <tr class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-3 text-center">
            <input type="radio" id="conf_stdj" x-model="form.conference_type" value="ATTENDANCE_ONLY" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" />
          </td>
          <td class="border border-gray-300 px-4 py-3">Attendance only</td>
          <td class="border border-gray-300 px-4 py-3 font-medium">4,000,000 VND</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Paper title -->
  <template x-if="['IOP_SCOPUS', 'Q3_JOURNAL', 'ABSTRACT_PRESENT'].includes(form.conference_type)">
    <div class="flex items-start gap-x-6">
      <label class="w-[250px] font-medium text-gray-700 pt-2 capitalize">Paper title <span class="text-red-600">*</span>:</label>
      <div class="flex-1">
        <input id="paper_title" x-model="form.paper_title" name="paper_title" class="w-full border-[.5px] border-gray-300 outline-none px-3 py-1 rounded" type="text" />
        <template x-if="errors['paper_title']">
          <p class="text-sm text-red-500" x-text="errors['paper_title']"></p>
        </template>
      </div>
    </div>
  </template>

  <!-- PAYMENT METHOD -->
  <div class="space-y-8">
    <div class="text-xl font-bold text-blue-800 border-b-2 border-blue-800 pb-2">PAYMENT METHOD</div>

    <!-- Option 1: ONLINE PAYMENT -->
    <div class="flex items-center">
      <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
        <label class="inline-flex items-center">
          <input type="radio" name="payment_method" value="online" x-model="form.payment_method" class="form-radio" />
          <span class="ml-2">ONLINE PAYMENT (6% transaction fee will be applied)</span>
        </label>
      </div>
    </div>

    <!-- Option 2: WIRE TRANSFER -->
    <div class="flex items-center">
      <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
        <label class="inline-flex items-center">
          <input type="radio" name="payment_method" value="wire" x-model="form.payment_method" class="form-radio" />
          <span class="ml-2">WIRE TRANSFER (Bank charges must be paid at your expense)</span>
        </label>
      </div>
    </div>

    <!-- Bank info (chỉ hiện nếu chọn wire) -->
    <template x-if="form.payment_method === 'wire'">
      <div class="space-y-3 p-6 bg-blue-50 w-fit rounded-lg">
        <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
          <div class="w-[200px] font-medium text-gray-700">Account Holder</div>
          <div class="text-gray-600">: HOA BINH INTERNATIONAL TOUR CO., TD</div>
        </div>
        <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
          <div class="w-[200px] font-medium text-gray-700">Account number</div>
          <div class="text-gray-600">: 852 805 141 4755 (VND)</div>
        </div>
        <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
          <div class="w-[200px] font-medium text-gray-700">Bank</div>
          <div class="text-gray-600">: Military Commercial Joint Stock Bank (MB) – Thang Long Branch</div>
        </div>
        <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
          <div class="w-[200px] font-medium text-gray-700">Bank code </div>
          <div class="text-gray-600">: 0131100620</div>
        </div>
        <div class="flex-1 flex gap-x-6 gap-y-2 flex-wrap items-center">
          <div class="w-[200px] font-medium text-gray-700">Swift code</div>
          <div class="text-gray-600">: MSCBVNVX</div>
        </div>
        <div class="font-semibold text-blue-800 italic mt-4">
          Please indicate "|Full name – Registration ID| paid for ICCFB 2025” as a reference and send proof of bank transfer to iccfb@hcmut.edu.vn & dh.qt1@hoabinh-group.com
        </div>
      </div>
    </template>
  </div>

  <!-- Submit button -->
  <div class="flex items-center justify-center pt-4">
    <button type="submit" class="py-3 px-8 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm cursor-pointer">
      REGISTER
    </button>
  </div>
</form>

{{-- <script src="{{ asset('js/registration-international-form.js') }}"></script> --}}
