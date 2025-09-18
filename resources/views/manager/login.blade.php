<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login - Tiko Iko On</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .neon-glow {
            box-shadow: 0 0 20px rgba(255, 46, 99, 0.3);
        }
        input:focus {
            box-shadow: 0 0 0 3px rgba(255, 46, 99, 0.2);
        }
    </style>
</head>
<body>
    <div class="login-container w-full max-w-md mx-4 p-8">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Orbitron', sans-serif;">
                🎆 Tiko Iko On
            </h1>
            <p class="text-xl text-white/80 mb-4">Manager Portal</p>
            <div class="w-20 h-1 bg-gradient-to-r from-pink-500 to-purple-600 mx-auto rounded-full"></div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-500/20 border border-red-500/50 text-white px-4 py-3 rounded-lg mb-6">
            @foreach($errors->all() as $error)
                <p><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('manager.authenticate') }}" class="space-y-6">
            @csrf
            
            <!-- Email Field -->
            <div>
                <label class="block text-white/90 font-medium mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email Address
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 outline-none transition-all"
                       placeholder="manager@tikoikoon.com">
            </div>

            <!-- Password Field -->
            <div>
                <label class="block text-white/90 font-medium mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 outline-none transition-all"
                       placeholder="Enter your password">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all neon-glow">
                <i class="fas fa-sign-in-alt mr-2"></i>Login to Dashboard
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/20"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-transparent text-white/60">Need access?</span>
            </div>
        </div>

        <!-- Admin Link -->
        <div class="text-center">
            <p class="text-white/70 mb-2">Contact your administrator to create a manager account</p>
            <a href="{{ route('admin.login') }}" class="text-pink-400 hover:text-pink-300 transition-colors">
                <i class="fas fa-shield-alt mr-1"></i>Admin Login
            </a>
        </div>

        <!-- Back to Website -->
        <div class="mt-8 text-center">
            <a href="{{ url('/') }}" class="text-white/60 hover:text-white transition-colors text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Back to Website
            </a>
        </div>
    </div>

    <!-- Floating Particles Background -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1;">
        <div style="position: absolute; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,46,99,0.1), transparent); border-radius: 50%; top: 10%; left: 10%; animation: float 6s ease-in-out infinite;"></div>
        <div style="position: absolute; width: 200px; height: 200px; background: radial-gradient(circle, rgba(138,43,226,0.1), transparent); border-radius: 50%; bottom: 20%; right: 15%; animation: float 8s ease-in-out infinite reverse;"></div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</body>
</html>