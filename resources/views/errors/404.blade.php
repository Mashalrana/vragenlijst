<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite('resources/js/app.tsx')
</head>
<body>
    <div class="h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-8xl font-bold text-blue-500 mb-2">
                404
            </h1>
            <h2 class="text-gray-500 text-3xl border-t-2 border-gray-200 pt-3">
                Page not found
            </h2>
            <button class="mt-5 bg-blue-500 text-white px-4 py-2 rounded-md" onclick="window.history.back()">
                Go back
            </button>
        </div>
    </div>
</body>
</html>
