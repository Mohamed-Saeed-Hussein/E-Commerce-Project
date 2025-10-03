@extends(session('auth.role') === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
    <div class="flex flex-col items-center justify-center px-4 mx-auto">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow dark:border xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-8 space-y-6 sm:p-10">
                <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white text-center">My Profile</h1>
                <p class="text-center text-gray-600 dark:text-gray-400">Manage your account settings and preferences</p>

                @if ($errors->any())
                <div class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</div>
                @endif
                @if (session('status'))
                <div class="text-sm text-green-600 dark:text-green-400">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ url('/profile/update') }}" class="space-y-4 md:space-y-6" autocomplete="off">
                    @csrf
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-base px-6 py-3 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Update Profile</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
