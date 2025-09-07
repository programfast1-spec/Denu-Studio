<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengajuan Cuti & Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ====================================================== --}}
            {{--        PANEL INFORMASI PANDUAN PERSETUJUAN CUTI        --}}
            {{-- ====================================================== --}}
            <div class="bg-green-100 border-l-4 border-green-500 text-gray-900 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <x-heroicon-s-information-circle class="h-6 w-6 text-blue-500 mr-4"/>
                    </div>
                    <div>
                        <p class="font-bold">Panduan Halaman Persetujuan Cuti & Izin</p>
                        <ul class="list-disc list-inside text-sm mt-2">
                            <li>Halaman ini menampilkan semua pengajuan cuti dan izin dari karyawan yang perlu Anda proses.</li>
                            <li>Tinjau setiap pengajuan dengan saksama. Periksa tanggal, alasan, dan <b>dokumen bukti</b> jika ada.</li>
                            <li>Klik tombol <b>"Proses"</b> untuk melihat detail lengkap dan memberikan keputusan (Setuju/Tolak).</li>
                            <li>Sangat disarankan untuk mengisi kolom <b>"Catatan Atasan"</b> saat memproses untuk memberikan feedback yang konstruktif kepada karyawan.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-4 border-b">Karyawan</th>
                                    <th class="py-2 px-4 border-b">Jenis</th>
                                    <th class="py-2 px-4 border-b">Tanggal</th>
                                    <th class="py-2 px-4 border-b">Bukti</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaves as $leave)
                                    <tr class="text-center">
                                        <td class="py-2 px-4 border-b text-left">{{ $leave->user->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ ucfirst($leave->type) }}</td>
                                        <td class="py-2 px-4 border-b">
                                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            @if($leave->proof_document)
                                                <button 
                                                    class="px-3 py-1 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition duration-300"
                                                    onclick="lihatBukti('{{ asset('storage/' . $leave->proof_document) }}')">
                                                    📄 Lihat
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            @if($leave->status == 'pending')
                                                <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Pending</span>
                                            @elseif($leave->status == 'approved')
                                                <span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Approved</span>
                                            @else
                                                <span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('atasan.leaves.edit', $leave) }}" class="text-indigo-600 hover:text-indigo-900">
                                               <x-secondary-button>
                                                    Proses
                                                </x-secondary-button>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tidak ada pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">{{ $leaves->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function lihatBukti(url) {
            Swal.fire({
                title: 'Lihat Bukti?',
                text: "Dokumen akan dibuka di tab baru.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, buka!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(url, '_blank');
                }
            });
        }
    </script>
</x-app-layout>
