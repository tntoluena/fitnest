<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitnest - Functional Prototype</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div id="login-section" class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Login Fitnest</h1>
            <form id="login-form" class="space-y-4">
                <input type="email" id="email" value="testerdua@example.com" required class="w-full px-3 py-2 border rounded-md" placeholder="Email">
                <input type="password" id="password" value="password" required class="w-full px-3 py-2 border rounded-md" placeholder="Password">
                <button type="submit" class="w-full py-3 px-4 rounded-md font-medium text-white bg-blue-600 hover:bg-blue-700">Login</button>
            </form>
            <div id="login-error" class="mt-4 text-red-500 text-center text-sm"></div>
        </div>
    </div>

    <div id="dashboard-section" class="hidden">
        <header class="bg-white shadow-md">
            <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
                <h1 class="font-bold text-xl text-blue-600">Fitnest</h1>
                <div>
                     <span class="text-gray-700">Hai, <span id="user-name" class="font-semibold"></span>!</span>
                     <button id="logout-button" class="ml-4 text-sm bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Logout</button>
                </div>
            </nav>
        </header>

        <main class="container mx-auto p-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-sm text-gray-500">Kalori Masuk</h3><p id="calories-consumed" class="text-2xl font-bold text-blue-500">-</p></div>
                <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-sm text-gray-500">Kalori Keluar</h3><p id="calories-burned" class="text-2xl font-bold text-orange-500">-</p></div>
                <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-sm text-gray-500">Kalori Bersih</h3><p id="net-calories" class="text-2xl font-bold text-green-500">-</p></div>
                <div class="bg-white p-4 rounded-lg shadow"><h3 class="text-sm text-gray-500">Target Harian</h3><p id="calorie-goal" class="text-2xl font-bold text-gray-700">-</p></div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow mb-4">
                 <h2 class="font-bold mb-2">Catat Makanan Cepat</h2>
                 <form id="add-food-form" class="flex items-center space-x-2">
                    <input type="text" id="food-name" placeholder="Nama Makanan" class="flex-grow px-3 py-2 border rounded-md">
                    <input type="number" id="food-calories" placeholder="Kalori" class="w-24 px-3 py-2 border rounded-md">
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">+</button>
                </form>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                 <h2 class="font-bold mb-2">Tanya FitBot AI</h2>
                 <form id="chatbot-form" class="flex items-center space-x-2">
                    <input type="text" id="chatbot-question" placeholder="Tanya apa saja tentang fitness..." class="flex-grow px-3 py-2 border rounded-md">
                    <button type="submit" class="bg-purple-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-600">Kirim</button>
                 </form>
                 <div id="chatbot-reply" class="mt-4 p-3 bg-gray-50 rounded-md text-gray-800 min-h-[50px]"></div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/prototype.js') }}"></script>
</body>
</html>