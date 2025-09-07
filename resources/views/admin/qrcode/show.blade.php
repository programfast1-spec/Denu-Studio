<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Code Absensi Hari Ini') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 text-center">

                {{-- Notifikasi sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="mb-4 text-gray-700">Tunjukkan QR Code ini kepada karyawan untuk melakukan absensi.</p>

                {{-- QR Code --}}
                <div class="inline-block p-4 border rounded-lg bg-gray-50 shadow-md">
                    {!! QrCode::size(300)->generate($qrToken) !!}
                </div>

                <p class="mt-4 text-sm text-gray-600">
                    Token Hari Ini: <br>
                    <span class="font-mono text-lg font-semibold">{{ $qrToken }}</span>
                </p>

                {{-- Tombol regenerate --}}
                <form id="regenerateForm" method="POST" action="{{ route('admin.qrcode.regenerate') }}">
                    @csrf
                    <button type="button" 
                        onclick="confirmRegenerate()"
                        class="mt-6 px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2 mx-auto">
                        🔄 Generate Ulang Token Hari Ini
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmRegenerate() {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin generate ulang token hari ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // biru-600
                cancelButtonColor: '#6b7280', // gray-500
                confirmButtonText: 'Ya, Generate',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('regenerateForm').submit();
                }
            })
        }
    </script>
</x-app-layout>
