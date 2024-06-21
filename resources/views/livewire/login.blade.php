<form class="space-y-4 " wire:submit.prevent="login">
    <div>
        <label for="email" class="block mb-2 text-sm font-normal">
            Email</label>
        <input type="email" name="email" id="email" wire:model.live="email"
            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
            placeholder="name@gmail.com" />
        @error('email')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password" class="block mb-2 text-sm font-normal">
            Password</label>
        <input type="password" name="password" id="password" placeholder="••••••••" wire:model.live="password"
            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
        @error('password')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror    
    </div>
    <div class="flex items-start">
        <a href="#" class="ms-auto text-sm text-blue-500 hover:underline">Lupa
            Password?</a>
    </div>
    <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Masuk
    </button>
    <div class="text-sm text-center text-gray-700">
        Belum punya akun? <a href="{{url('/registrasi')}}"
            class="text-blue-500 hover:underline">Registrasi</a>
    </div>
</form>
