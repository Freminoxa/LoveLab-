<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tiko Iko On</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        .admin-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: #FF2E63;
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            color: white;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #FF2E63;
            box-shadow: 0 0 0 3px rgba(255, 46, 99, 0.1);
        }
        
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 46, 99, 0.3);
        }
        
        .error {
            color: #ef4444;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        
        .success {
            color: #10b981;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="login-card">
            <div class="login-header">
                <h1><i class="fas fa-shield-alt"></i> Admin Login</h1>
                <p>Tiko Iko On - Administration Panel</p>
            </div>
            
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            
            <form method="POST" action="{{ route('admin.authenticate') }}">
                @csrf
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Admin Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Enter admin password"
                        autofocus
                    >
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login to Admin Panel
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ url('/') }}" style="color: #08D9D6; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>
