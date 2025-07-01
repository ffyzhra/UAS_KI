<x-filament::page>
    <x-filament::card>
        <div class="text-xl font-semibold">👋 Selamat Datang di Dashboard Mahasiswa</div>
        <div class="mt-2 text-gray-600">
            Total Pengguna: <strong>{{ $userCount }}</strong>
        </div>
    </x-filament::card>

    <x-filament::card class="mt-6">
        <div class="text-lg font-semibold mb-4">📋 Log Aktivitas Terbaru</div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-700 border-b">
                    <th class="py-2">Type</th>
                    <th class="py-2">Event</th>
                    <th class="py-2">Deskripsi</th>
                    <th class="py-2">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">{{ $log->type }}</td>
                        <td class="py-2">{{ $log->event }}</td>
                        <td class="py-2">{{ $log->description }}</td>
                        <td class="py-2">{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada log aktivitas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-filament::card>
</x-filament::page>
