@extends('layouts.admin')

@section('content')
    <div x-data="{
        showCreateModal: false,
        showEditModal: false,
        name: '',
        email: '',
        role: '',
        userId: '',
        editRoute: '',

        openCreateModal() {
            this.name = '';
            this.email = '';
            this.role = '';
            this.showCreateModal = true;
        },

        openEditModal(user) {
            this.userId = user.id;
            this.name = user.name;
            this.email = user.email;
            this.role = user.role;
            this.editRoute = `{{ url('admin/users') }}/${user.id}`;
            this.showEditModal = true;
        }
    }" class="p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen User</h1>
            <button @click="openCreateModal()"
                class="bg-pink-600 text-white px-4 py-2 rounded shadow hover:bg-pink-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah User
            </button>
        </div>

        <!-- Search & Filter Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-100">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-grow">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="pl-10 focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 rounded-lg py-2 border shadow-sm"
                            placeholder="Contoh: Budi atau budi@example.com">
                    </div>
                </div>

                <div class="w-full md:w-64">
                    <label for="role_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter Role</label>
                    <select name="role" id="role_filter"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-lg border shadow-sm">
                        <option value="semua" {{ request('role') == 'semua' ? 'selected' : '' }}>Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="bidan" {{ request('role') == 'bidan' ? 'selected' : '' }}>Bidan</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                        Terapkan
                    </button>
                    @if (request()->has('search') || request()->has('role'))
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-lg border-t-4 border-pink-500 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-pink-600 to-rose-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Dibuat Pada</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $roleColor = match ($user->role) {
                                            'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'dokter' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'bidan' => 'bg-pink-100 text-pink-800 border-pink-200',
                                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $roleColor }} shadow-sm">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <button @click="openEditModal({{ $user }})"
                                            class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-800 rounded-md transition-colors text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </button>
                                        @if ($user->id !== auth()->id())
                                            <button @click="openDeleteModal($el.closest('tr').querySelector('form'), '{{ $user->name }}')"
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-800 rounded-md transition-colors text-xs font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </button>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-400 rounded-md cursor-not-allowed text-xs font-semibold" title="Tidak dapat menghapus akun sendiri">
                                                Hapus
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p class="text-lg font-medium">Belum ada data user</p>
                                        <p class="text-sm mt-1">Silakan tambah user atau ubah filter pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Create User Modal -->
        <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showCreateModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity"></div>
                
                <div class="bg-white rounded-xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full z-10 overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4 flex justify-between items-center text-white">
                        <h3 class="text-xl font-bold">Tambah User Baru</h3>
                        <button @click="showCreateModal = false" class="hover:text-pink-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                                <select name="role" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="dokter">Dokter</option>
                                    <option value="bidan">Bidan</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                    <input type="password" name="password" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi</label>
                                    <input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" @click="showCreateModal = false" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 shadow-md transition font-bold">Simpan User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showEditModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity"></div>
                
                <div class="bg-white rounded-xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full z-10 overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4 flex justify-between items-center text-white">
                        <h3 class="text-xl font-bold">Edit Data User</h3>
                        <button @click="showEditModal = false" class="hover:text-pink-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form :action="editRoute" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" x-model="name" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" x-model="email" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                                <select name="role" x-model="role" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                    <option value="admin">Admin</option>
                                    <option value="dokter">Dokter</option>
                                    <option value="bidan">Bidan</option>
                                </select>
                            </div>
                            <div class="pt-2 border-t border-gray-100">
                                <p class="text-xs text-gray-500 mb-2 italic">* Kosongkan password jika tidak ingin mengubah</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                                        <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi</label>
                                        <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" @click="showEditModal = false" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 shadow-md transition font-bold">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection