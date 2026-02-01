<section class="space-y-6">
    <p class="text-gray-600">
        Setelah akun Anda dihapus, semua data dan sumber daya akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data apa pun yang ingin Anda simpan.
    </p>

    <button 
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold"
    >
        Hapus Akun
    </button>

    <!-- Modal -->
    <div 
        x-data="{ open: false }"
        x-show="open"
        x-on:open-modal.window="open = ($event.detail.name === 'confirm-user-deletion')"
        x-on:close.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center"
        style="display: none;"
    >
        <!-- Backdrop -->
        <div 
            x-show="open"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50"
            x-on:click="open = false"
        ></div>

        <!-- Modal Content -->
        <div 
            x-show="open"
            x-transition
            class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6"
        >
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Apakah Anda yakin ingin menghapus akun?
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Masukkan password Anda untuk mengkonfirmasi penghapusan akun.
                    </p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('password', 'userDeletion') border-red-500 @enderror"
                        placeholder="••••••••"
                    />
                    @error('password', 'userDeletion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <button 
                        type="button"
                        x-on:click="open = false"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold"
                    >
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
