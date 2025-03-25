<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Enter your email to receive a password reset link.') }}
    </div>

    <!-- Bootstrap Alerts for Success & Errors -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
        </div>
        <div class="row d-flex justify-content-between align-items-center">
    <!-- Submit Button -->
    <div>
        <x-primary-button class="btn btn-primary">
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
    </div>
    
    <!-- Back to Login Link -->
    <div>
        <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
    </div>
</div>

    </form>

    <!-- Bootstrap JS for Dismissing Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-guest-layout>
