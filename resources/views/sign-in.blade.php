@extends('example.layouts.default.main')
@section('content')
<div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
    <a href="{{ url('/')}}" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
        <img src="{{ asset('storage/'.$setting->logo) }}" class="mr-4 h-11" alt="Stockify">
        <span>{{$setting->name}}</span>
    </a>
    <!-- Card -->
    <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Sign in to platform
        </h2>
        <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div>
                <label for="username_or_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your username or email</label>
                <input type="text" name="username_or_email" id="username_or_email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username atau email" required>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
            </div>
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <script>
  // Seleksi elemen checkbox
  const rememberCheckbox = document.getElementById('remember');

  // Fungsi untuk memuat status terakhir dari localStorage
  function loadCheckboxState() {
    const isChecked = localStorage.getItem('rememberCheckbox') === 'true';
    rememberCheckbox.checked = isChecked; // Atur status checkbox
  }

  // Fungsi untuk menyimpan status checkbox ke localStorage
  function saveCheckboxState() {
    localStorage.setItem('rememberCheckbox', rememberCheckbox.checked);
  }

  // Muat status saat halaman dimuat
  document.addEventListener('DOMContentLoaded', loadCheckboxState);

  // Simpan status saat checkbox diubah
  rememberCheckbox.addEventListener('change', saveCheckboxState);
</script>

                <div class="ml-3 text-sm">
                <label for="remember" class="font-medium text-gray-900 dark:text-white">Remember me</label>
                </div>
                <a href="#" class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">Lost Password?</a>
            </div>
            <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login to your account</button>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Not registered? <a href="#" class="text-primary-700 hover:underline dark:text-primary-500">Create account</a>
            </div>
        </form>
        @if (session('gagal'))
        <p class="text-red-700" style="color: red;">{{ session('gagal') }}</p>
        @endif
    </div>
</div>
@endsection
