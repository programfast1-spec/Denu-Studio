<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User & Gaji') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        {{-- Notifikasi sukses / error --}}
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="p-6 space-y-6">
                {{-- Form Update --}}
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div>
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" class="block mt-1 w-full"
                            type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full"
                            type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="karyawan" @selected(old('role', $user->role) == 'karyawan')>Karyawan</option>
                            <option value="atasan" @selected(old('role', $user->role) == 'atasan')>Atasan</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Gaji Pokok -->
                    <div>
                        <x-input-label for="gaji_pokok" :value="__('Gaji Pokok')" />
                        <x-text-input id="gaji_pokok" class="block mt-1 w-full"
                            type="number" name="gaji_pokok" :value="old('gaji_pokok', $user->gaji_pokok)" required />
                        <x-input-error :messages="$errors->get('gaji_pokok')" class="mt-2" />
                    </div>

                    <!-- Tarif Lembur -->
                    <div>
                        <x-input-label for="tarif_lembur_per_jam" :value="__('Tarif Lembur per Jam')" />
                        <x-text-input id="tarif_lembur_per_jam" class="block mt-1 w-full"
                            type="number" name="tarif_lembur_per_jam"
                            :value="old('tarif_lembur_per_jam', $user->tarif_lembur_per_jam)" required />
                        <x-input-error :messages="$errors->get('tarif_lembur_per_jam')" class="mt-2" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Kembali
                        </a>

                        <x-primary-button>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>

                {{-- Form Hapus --}}
                <form id="delete-user-form" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                    @csrf
                    @method('DELETE')

                    <button type="button" onclick="confirmDelete()"
                        class="mt-4 w-mid px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Hapus User
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete() {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "User ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-user-form').submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
