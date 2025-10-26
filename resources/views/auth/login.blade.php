<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<style>
    input:-webkit-autofill {
        box-shadow: 0 0 0px 1000px #fee2e2 inset !important;
        -webkit-text-fill-color: #374151 !important;
    }
</style>

<body class="bg-gray-100 min-h-screen flex items-start justify-center font-sans">
    <main class="w-full max-w-md px-4 pt-12">

        <!-- Top header: icon, title, subtitle -->
        <div class="text-center mb-6">
            <div class="mx-auto mb-4" style="width:78px; height:78px;">
                <div class="rounded-full flex items-center justify-center" style="width:78px; height:78px; background: linear-gradient(135deg,#dc2626 0%,#b91c1c 100%); box-shadow: 0 8px 20px rgba(220,38,38,0.14);">
                    <!-- lock icon -->
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 17a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" fill="#fff"/>
                        <path d="M17 9V7a5 5 0 10-10 0v2H5v10h14V9h-2zM9 7a3 3 0 116 0v2H9V7z" fill="#fff"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900" style="font-family: Arial, Helvetica, sans-serif;">Sistem Workshop</h1>
            <p class="text-sm text-gray-500 mt-1">Masuk untuk mengakses sistem workshop</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

            <!-- Form -->
            <form method="POST" action="{{ url('/login') }}" novalidate class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" autofocus
                        class="w-full border border-red-500 bg-red-100 rounded-lg px-3 py-2.5 text-gray-700
                            focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition
                            autofill:bg-red-100" required>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password"
                        class="w-full border border-red-500 bg-red-100 rounded-lg px-3 py-2.5 text-gray-700
                            focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition
                            autofill:bg-red-100" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Captcha -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Captcha</label>
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ captcha_src('flat') }}"
                             alt="Kode captcha - klik untuk refresh"
                             id="captcha-img"
                             class="border rounded-lg h-16 w-auto cursor-pointer shadow">
                        <button type="button" id="refresh-captcha"
                            class="px-3 py-2 text-sm bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">
                            Refresh
                        </button>
                    </div>
                    <input type="text" name="captcha" placeholder="Masukkan kode di atas"
                    class="w-full border border-red-500 bg-red-100 rounded-lg px-3 py-2.5 text-gray-700
                            focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition
                            autofill:bg-red-100" required>

                    @error('captcha')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-semibold text-lg shadow-md transition">
                    Login
                </button>
            </form>
        </div>
    </main>

    <script>
        function refreshCaptcha() {
            const img = document.getElementById('captcha-img');
            if (!img) return;
            img.src = '{{ captcha_src("flat") }}' + '?_=' + Date.now();
        }

        document.getElementById('refresh-captcha')?.addEventListener('click', refreshCaptcha);
        document.getElementById('captcha-img')?.addEventListener('click', refreshCaptcha);
    </script>
</body>
</html>
