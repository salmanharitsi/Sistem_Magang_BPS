<form class="space-y-4 " wire:submit.prevent="reset_password">
    <div class="mt-1">
        <label for="password" class="block mb-1 text-sm font-normal">Password</label>
        <div class="relative group">
            <input type="password" name="password" id="password" placeholder="Masukkan password"
                wire:model.live="password"
                class="bg-gray-50 pr-10 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            <button type="button" onclick="togglePasswordVisibility('password')"
                class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                <i id="togglePasswordIcon_password" class="fas fa-eye"></i>
            </button>
        </div>
        @if ($errors->has('password'))
            <ul class="list-disc pl-5 text-red-600 text-[11px] mt-2">
                @foreach ($errors->get('password') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="mt-1">
        <label for="confirm_password" class="block mb-1 text-sm font-normal">Konfirmasi Password</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi password"
            wire:model.live="confirm_password"
            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
        @error('confirm_password')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Reset Password
    </button>
    <div class="text-sm text-center text-gray-700">
        Kembali coba untuk masuk? <a href="{{ url('/login') }}" class="text-blue-500 hover:underline">Masuk</a>
    </div>
</form>

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('togglePasswordIcon_' + fieldId);
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function openPreview(url) {
        const screenWidth = window.screen.width;
        const screenHeight = window.screen.height;
        const width = screenWidth / 2;
        const height = screenHeight / 2;
        const left = (screenWidth - width) / 2;
        const top = (screenHeight - height) / 2;

        const newWindow = window.open(
            '',
            '',
            `width=${width},height=${height},top=${top},left=${left}`
        );
        newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
        newWindow.document.title = "Image Preview";
    }
</script>
