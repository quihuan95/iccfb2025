<div>
  <div class="max-w-md mx-auto p-6 bg-white rounded-xl shadow space-y-4">
    <x-input label="Họ và tên" placeholder="Nhập họ tên" wire:model.defer="name" name="name" />

    <x-input label="Email" placeholder="your@email.com" wire:model.defer="email" name="email" />

    <x-textarea label="Lời nhắn" placeholder="Bạn muốn nói gì?" wire:model.defer="message" name="message" rows="4" />

    <x-button primary label="Gửi liên hệ" spinner wire:click="submit" class="bg-blue-300" />
  </div>

  <!-- Notification -->
  <wireui-notifications />
</div>
