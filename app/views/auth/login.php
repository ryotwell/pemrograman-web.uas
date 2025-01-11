<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Your App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-xl shadow-2xl max-w-md w-full mx-4">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-blue-900">Welcome Back</h2>
            <p class="text-blue-600/80 mt-3">Please sign in to your account</p>
        </div>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-blue-800">Email</label>
                <input type="email" id="email" name="email" required 
                    class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-blue-800">Password</label>
                <input type="password" id="password" name="password" required 
                    class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember-me" name="remember-me" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-blue-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-blue-700">Remember me</label>
                </div>
            </div>
            
            <button type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:-translate-y-0.5">
                Sign in
            </button>
        </form>
        
        <p class="mt-8 text-center text-sm text-blue-600/80">
            Don't have an account? 
            <a href="/register" class="font-semibold text-blue-600 hover:text-blue-800 transition duration-200">Sign up</a>
        </p>
    </div>
</body>
</html>