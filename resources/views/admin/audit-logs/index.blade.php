<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ====================================================== --}}
            {{--           PANEL INFORMASI PANDUAN AUDIT LOG          --}}
            {{-- ====================================================== --}}
            <div class="bg-green-100 border-l-4 border-green-500 text-gray-900 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <x-heroicon-s-information-circle class="h-6 w-6 text-blue-500 mr-4"/>
                    </div>
                    <div>
                        <p class="font-bold">Panduan Halaman Audit Log</p>
                        <ul class="list-disc list-inside text-sm mt-2">
                            <li>Halaman ini adalah catatan "CCTV" digital untuk semua aktivitas penting di dalam sistem.</li>
                            <li><b>User Pelaku:</b> Siapa yang melakukan perubahan (misal: Admin, Atasan).</li>
                            <li><b>Aktivitas:</b> Tindakan yang dilakukan (misal: menambah data karyawan, memperbarui cuti).</li>
                            <li><b>Detail Perubahan:</b> Menampilkan data sebelum (<span class="text-red-600">Data Lama</span>) dan sesudah (<span class="text-green-600">Data Baru</span>) perubahan.</li>
                            <li>Log ini dibuat otomatis oleh sistem dan tidak dapat diubah demi menjaga integritas data.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ======================= TABEL LOG ======================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Waktu</th>
                                    <th class="py-2 px-4 border-b text-left">User Pelaku</th>
                                    <th class="py-2 px-4 border-b text-left">Aktivitas</th>
                                    <th class="py-2 px-4 border-b text-left">Detail Perubahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr class="text-sm">
                                        {{-- Waktu --}}
                                        <td class="py-2 px-4 border-b align-top whitespace-nowrap">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </td>

                                        {{-- User Pelaku --}}
                                        <td class="py-2 px-4 border-b align-top">
                                            {{ $log->user->name ?? 'System' }}
                                        </td>

                                        {{-- Aktivitas --}}
                                        <td class="py-2 px-4 border-b align-top">
                                            <span class="font-semibold text-green-800">
                                                {{ ucwords(str_replace('_', ' ', $log->activity)) }}
                                            </span>
                                            <span class="block text-xs text-green-500">
                                                {{ str_replace('App\\Models\\', '', $log->auditable_type) }}
                                                #{{ $log->auditable_id }}
                                            </span>
                                        </td>

                                        {{-- Detail Perubahan --}}
                                        <td class="py-2 px-4 border-b align-top text-xs">
                                            @php
                                                $model = str_replace('App\\Models\\', '', $log->auditable_type);
                                                $oldValues = is_array($log->old_values) ? $log->old_values : json_decode($log->old_values, true);
                                                $newValues = is_array($log->new_values) ? $log->new_values : json_decode($log->new_values, true);
                                            @endphp

                                            {{-- Update --}}
                                            @if(!empty($oldValues) && !empty($newValues))
                                                <div class="font-semibold text-yellow-700">✏️ Update {{ $model }} #{{ $log->auditable_id }}</div>
                                                @foreach($newValues as $field => $new)
                                                    @php $old = $oldValues[$field] ?? '-'; @endphp
                                                    @if($old != $new)
                                                        <div class="ml-2 text-gray-700">🔄 <b>{{ ucfirst($field) }}</b>: {{ $old }} → {{ $new }}</div>
                                                    @endif
                                                @endforeach

                                            {{-- Create --}}
                                            @elseif(!empty($newValues))
                                                <div class="font-semibold text-green-700">✅ Create {{ $model }} #{{ $log->auditable_id }}</div>
                                                @foreach($newValues as $field => $new)
                                                    <div class="ml-2 text-gray-700">➕ <b>{{ ucfirst($field) }}</b>: {{ $new }}</div>
                                                @endforeach

                                            {{-- Delete --}}
                                            @elseif(!empty($oldValues))
                                                <div class="font-semibold text-red-700">🗑 Delete {{ $model }} #{{ $log->auditable_id }}</div>
                                                @foreach($oldValues as $field => $old)
                                                    <div class="ml-2 text-gray-700">❌ <b>{{ ucfirst($field) }}</b>: {{ $old }}</div>
                                                @endforeach

                                            {{-- Kosong --}}
                                            @else
                                                <div class="text-gray-500">Tidak ada detail perubahan.</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Tidak ada aktivitas tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
