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

<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans">
    <main class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

            <!-- Logo -->
            <div class="flex justify-center mb-2">
                <img src="{{ asset('image/logo-ahm.png') }}"
                    alt="KYB"
                    class="w-32 md:w-36 object-contain">
            </div>

            <!-- Form -->
            <form method="POST" action="{{ url('/login') }}" novalidate class="space-y-5">
                @csrf

               <!-- NPK -->
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
