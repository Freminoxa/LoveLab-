<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Manager Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-key text-2xl text-yellow-600"></i>
                </div>
                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Change Your Password
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    For security reasons, please change your password before accessing the dashboard
                </p>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-500 mr-2 mt-0.5"></i>
                        {{ session('info') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2 mt-0.5"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Change Password Form -->
            <div class="bg-white shadow-xl rounded-lg">
                <form class="px-8 py-8 space-y-6" action="{{ route('manager.update-password') }}" method="POST">
                    @csrf
                    
                    <!-- Current Manager Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600">
                            <strong>Welcome, {{ session('manager_name') }}!</strong><br>
                            <span class="text-xs">{{ session('manager_email') }}</span>
                        </p>
                    </div>

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="current_password" 
                                   id="current_password" 
                                   required
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror"
                                   placeholder="Enter your current password">
                            <button type="button" 
                                    onclick="togglePassword('current_password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="current_password_icon"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="new_password" 
                                   id="new_password" 
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('new_password') border-red-500 @enderror"
                                   placeholder="Enter your new password">
                            <button type="button" 
                                    onclick="togglePassword('new_password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="new_password_icon"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Password Requirements -->
                        <div class="mt-2">
                            <p class="text-xs text-gray-500 mb-2">Password must contain:</p>
                            <ul class="text-xs text-gray-500 space-y-1">
                                <li id="length-req" class="flex items-center">
                                    <i class="fas fa-times text-red-500 w-4 mr-1" id="length-icon"></i>
                                    At least 8 characters
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="new_password_confirmation" 
                                   id="new_password_confirmation" 
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Confirm your new password">
                            <button type="button" 
                                    onclick="togglePassword('new_password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="new_password_confirmation_icon"></i>
                            </button>
                        </div>
                        <p id="password-match-message" class="mt-1 text-sm hidden"></p>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-shield-alt text-yellow-600 mr-2 mt-0.5"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Security Notice:</p>
                                <p>Choose a strong password that you haven't used elsewhere. You can change your password again later from your profile settings.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                id="submit-btn"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-key mr-2"></i>
                            Change Password & Continue
                        </button>
                    </div>

                    <!-- Logout Option -->
                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            Need to login with a different account?
                            <a href="{{ route('manager.logout') }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Hidden logout form -->
                <form id="logout-form" action="{{ route('manager.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');
            
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

        // Password validation
        document.getElementById('new_password').addEventListener('input', function() {
            const password = this.value;
            const lengthReq = document.getElementById('length-req');
            const lengthIcon = document.getElementById('length-icon');
            
            // Check length
            if (password.length >= 8) {
                lengthIcon.classList.remove('fa-times', 'text-red-500');
                lengthIcon.classList.add('fa-check', 'text-green-500');
            } else {
                lengthIcon.classList.remove('fa-check', 'text-green-500');
                lengthIcon.classList.add('fa-times', 'text-red-500');
            }

            checkPasswordMatch();
        });

        // Password confirmation validation
        document.getElementById('new_password_confirmation').addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            const password = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;
            const message = document.getElementById('password-match-message');
            const submitBtn = document.getElementById('submit-btn');

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    message.className = 'mt-1 text-sm text-green-600';
                    message.textContent = 'Passwords match!';
                    message.classList.remove('hidden');
                    submitBtn.disabled = false;
                } else {
                    message.className = 'mt-1 text-sm text-red-600';
                    message.textContent = 'Passwords do not match.';
                    message.classList.remove('hidden');
                    submitBtn.disabled = true;
                }
            } else {
                message.classList.add('hidden');
                submitBtn.disabled = false;
            }
        }
    </script>
</body>
</html>