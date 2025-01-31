<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Payment Instructions</h2>
            
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-bold mb-2">Amount to Pay: KSH {{ number_format($booking->price, 2) }}</h3>
                <div class="mb-4">
                    <p class="font-bold">Till Number: 123456</p>
                </div>
            </div>

            <div class="mb-6">
                <h4 class="font-bold mb-2">How to Pay via M-PESA:</h4>
                <ol class="list-decimal pl-4">
                    <li class="mb-2">Go to M-PESA menu</li>
                    <li class="mb-2">Select "Lipa na M-PESA"</li>
                    <li class="mb-2">Select "Buy Goods and Services"</li>
                    <li class="mb-2">Enter Till Number: 123456</li>
                    <li class="mb-2">Enter Amount: KSH {{ number_format($booking->price, 2) }}</li>
                    <li class="mb-2">Enter your M-PESA PIN</li>
                    <li class="mb-2">Confirm the transaction</li>
                </ol>
            </div>

            <form action="{{ route('confirm.payment') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                
                <div>
                    <label for="mpesa_code" class="block text-sm font-medium text-gray-700 mb-1">
                        Enter M-PESA Confirmation Code
                    </label>
                    <input 
                        type="text" 
                        id="mpesa_code" 
                        name="mpesa_code" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., QWE1234XYZ"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200"
                >
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>
</body>
</html>