
{{-- Success Tostr --}}
@if (!empty(session('success')))
    <div id="toast-success"
        class="toast-hidden z-50 fixed top-3 right-3 flex items-center w-full max-w-xs md:max-w-sm p-4 mb-4 text-white bg-green-600 rounded-lg shadow
                delay-[100ms] duration-[300ms] taos:translate-x-[100px] taos:opacity-0"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 rounded-lg bg-green-600 text-green-800">
            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ Session::get('success.title') }}</div>
    </div>
@endif

{{-- Error Tostr --}}
@if (!empty(session('error')))
    <div id="toast-danger"
        class="toast-hidden z-50 fixed top-3 right-3 flex items-center w-full max-w-xs md:max-w-sm p-4 mb-4 text-white bg-red-600 rounded-lg shadow
                delay-[100ms] duration-[300ms] taos:translate-x-[100px] taos:opacity-0"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 rounded-lg bg-red-600 text-red-800">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ Session::get('error.title') }}</div>
    </div>
@endif

<script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toasts = document.querySelectorAll('.toast-hidden');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 500); 
            }, 5000); 
        });
    });
</script>
