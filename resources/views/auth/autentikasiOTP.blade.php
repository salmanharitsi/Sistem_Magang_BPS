<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Autentikasi - Simagang</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body>

    <div class="flex flex-col lg:flex-row relative">
        <div class="m-0 p-0 w-full h-[15vh] md:h-[100vh] relative gradient-overlay-login z-[0] basis-[65%]">
            <a href="{{ url('/') }}"
                class="w-fit text-gray-800 text-sm absolute flex items-center justify-center gap-4 top-5 md:top-10 left-4 md:left-10 px-5 py-2 bg-white hover:bg-gray-200 transition-all ease-in rounded-lg">
                <i class="fa-solid fa-arrow-left"></i>
                <p>kembali ke beranda</p>
            </a>
            <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class= "object-cover w-full h-full">
        </div>
        <div
            class="relative px-5 py-5 md:px-20 md:py-10 flex flex-col items-center justify-center gap-7 z-10 basis-[35%]">
            <div class="flex w-full items-center justify-start md:justify-center md:mb-8">
                <img class="w-[90px]" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="flex flex-col w-full items-start gap-4 text-gray-800">
                <h1 class="font-semibold text-lg md:text-2xl">Masukkan Kode OTP<br>yang Dikirim ke Email Anda</h1>
            </div>
            <div class="w-full rounded-lg">
                <form action="{{ route('verify.otp.submit', ['id' => $id]) }}" method="POST"
                    class="flex flex-col gap-6">
                    @csrf
                    <div class="flex justify-between gap-2">
                        <input type="text" name="otp[]"
                            class="w-12 h-12 text-center text-xl font-semibold border-2 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            maxlength="1">
                        <input type="text" name="otp[]"
                            class="w-12 h-12 text-center text-xl font-semibold border-2 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            maxlength="1">
                        <input type="text" name="otp[]"
                            class="w-12 h-12 text-center text-xl font-semibold border-2 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            maxlength="1">
                        <input type="text" name="otp[]"
                            class="w-12 h-12 text-center text-xl font-semibold border-2 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            maxlength="1">
                        <input type="text" name="otp[]"
                            class="w-12 h-12 text-center text-xl font-semibold border-2 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            maxlength="1">
                        <input type="text" name="otp[]"
                            class="w-12 h-12 text-center text-xl font-semibold border-2 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            maxlength="1">
                    </div>
                    <input type="hidden" name="otp" id="otpFull">
                    <button type="submit"
                        class="w-full py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Verifikasi OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <form id="resendForm" action="{{ route('resend.otp', ['id' => $id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:underline disabled:text-gray-400"
                            id="resendBtn" disabled>
                            Kirim Ulang Kode OTP
                        </button>
                    </form>
                    <span id="cooldownTimer" class="text-sm text-gray-500 block mt-2"></span>
                </div>
            </div>
        </div>
    </div>

    @include('_message')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get form elements
            const otpForm = document.querySelector('form[action*="verify-otp"]');
            const inputs = otpForm.querySelectorAll('input[name^="otp"]');
            const otpFull = document.getElementById('otpFull');
            const verifyButton = otpForm.querySelector('button[type="submit"]');

            // Initially disable verify button
            function disableVerifyButton() {
                verifyButton.disabled = true;
                verifyButton.classList.add('opacity-50', 'cursor-not-allowed');
            }

            function enableVerifyButton() {
                verifyButton.disabled = false;
                verifyButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            // Call disable on page load
            disableVerifyButton();

            // Check if OTP is complete
            function checkOTPComplete() {
                const filledInputs = Array.from(inputs).filter(input => input.value.length === 1);

                if (filledInputs.length === 6) {
                    enableVerifyButton();
                    // const otp = filledInputs.map(input => input.value).join(''); // Ubah ini
                    otpFull.value = otp;
                    console.log('Combined OTP:', otp);
                } else {
                    disableVerifyButton();
                }
            }

            // Input handling
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1) {
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                    checkOTPComplete();
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus();
                        checkOTPComplete();
                    }
                });
            });

            // Prevent form submission if not complete
            otpForm.addEventListener('submit', function(e) {
                const filledInputs = Array.from(inputs).filter(input => input.value.length === 1);
                if (filledInputs.length !== 6) {
                    e.preventDefault();
                    disableVerifyButton();
                    return false;
                }
            });

            // Add paste handler for OTP
            document.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);

                if (pastedText.length === 6) {
                    inputs.forEach((input, index) => {
                        input.value = pastedText[index] || '';
                    });
                    checkOTPComplete();
                }
            });


            const resendForm = document.getElementById('resendForm');
            const resendBtn = document.getElementById('resendBtn');
            const cooldownTimer = document.getElementById('cooldownTimer');

            const userId = window.location.pathname.split('/').pop();
            const cooldownKey = `otp_cooldown_${userId}`;
            const endTimeKey = `otp_end_time_${userId}`;

            function getRemainingTime() {
                const endTime = localStorage.getItem(endTimeKey);
                if (!endTime) return 0;

                const remaining = Math.ceil((parseInt(endTime) - Date.now()) / 1000);
                return remaining > 0 ? remaining : 0;
            }

            function startCooldown(seconds) {
                // Store end time in localStorage
                const endTime = Date.now() + (seconds * 1000);
                localStorage.setItem(endTimeKey, endTime.toString());

                updateCooldownUI();
            }

            function updateCooldownUI() {
                const remainingTime = getRemainingTime();

                if (remainingTime <= 0) {
                    resendBtn.disabled = false;
                    cooldownTimer.textContent = '';
                    // Clean up localStorage when timer completes
                    localStorage.removeItem(endTimeKey);
                    return;
                }

                resendBtn.disabled = true;
                cooldownTimer.textContent = `Tunggu ${remainingTime} detik untuk kirim ulang`;

            
                setTimeout(updateCooldownUI, 1000);
            }

            //  Initialize cooldown timer from localStorage or start fresh
            let remainingTime = getRemainingTime();
            if (remainingTime > 0) {
                // Resume existing cooldown
                resendBtn.disabled = true;
                updateCooldownUI();
            } else {
                // Start with default cooldown time if this is the first visit
                const initialCooldown = localStorage.getItem(cooldownKey);
                if (initialCooldown === null) {
                    localStorage.setItem(cooldownKey, 'true');
                    startCooldown(30);
                } else {
                    resendBtn.disabled = false;
                }
            }

            // [CHANGED] Updated submit handler to use the new startCooldown function
            resendForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!resendBtn.disabled) {
                    startCooldown(30);
                    this.submit();
                }
            });

            // Tambahkan handler submit form
            otpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (verifyButton.disabled) {
                    return false;
                }

                const otp = Array.from(inputs)
                    .map(input => input.value)
                    .join('');

                otpFull.value = otp;
                console.log('Submitting OTP:', otp);
                this.submit();
            });
        });
    </script>

    @livewireScripts
</body>

</html>
