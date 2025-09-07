<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User & Gaji') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ====================================================== --}}
            {{--         PANEL INFORMASI PANDUAN MANAJEMEN USER         --}}
            {{-- ====================================================== --}}
            <div class="bg-green-100 border-l-4 border-green-500 text-gray-900 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><x-heroicon-s-information-circle class="h-6 w-6 text-blue-500 mr-4"/></div>
                    <div>
                        <p class="font-bold">Panduan Halaman Manajemen User</p>
                        <ul class="list-disc list-inside text-sm mt-2">
                            <li>Halaman ini digunakan untuk mengelola data semua pengguna dengan role <b>Karyawan</b> dan <b>Atasan</b>.</li>
                            <li>Gunakan tombol <b>"Tambah User Baru"</b> untuk mendaftarkan akun baru ke dalam sistem.</li>
                            <li>Klik <b>"Edit"</b> pada setiap baris untuk mengubah detail, role, serta mengatur <b>Gaji Pokok</b> dan <b>Tarif Lembur</b> per jam untuk karyawan.</li>
                            <li>Pengguna yang baru ditambahkan akan memiliki Gaji Pokok dan Tarif Lembur Rp 0 secara default.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.users.create') }}">
                            <x-primary-button>
                                {{ __('Tambah User Baru') }}
                            </x-primary-button>
                        </a>
                    </div>
                    
                    @if (session('status'))
                        <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-4 border-b">Nama</th>
                                    <th class="py-2 px-4 border-b">Email</th>
                                    <th class="py-2 px-4 border-b">Role</th>
                                    <th class="py-2 px-4 border-b">Gaji Pokok</th>
                                    <th class="py-2 px-4 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="text-center">
                                        <td class="py-2 px-4 border-b text-left">{{ $user->name }}</td>
                                        <td class="py-2 px-4 border-b text-left">{{ $user->email }}</td>
                                        <td class="py-2 px-4 border-b">{{ ucfirst($user->role) }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->gaji_pokok, 2, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <button 
                                                onclick="confirmEdit('{{ route('admin.users.edit', $user) }}')" 
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-200 ease-in-out flex items-center gap-2 mx-auto"
                                            >
                                                {{-- Ikon edit --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-2 4h2m-6 8h12M4 15h16M4 19h16M4 11h16M4 7h16" />
                                                </svg>
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tidak ada data user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmEdit(url) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin mengedit data user ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5', // indigo-600
                cancelButtonColor: '#6b7280', // gray-500
                confirmButtonText: 'Ya, Edit',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
</x-app-layout>
