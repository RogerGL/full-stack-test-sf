<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullStack - Test</title>
</head>

<body class="bg-secondary">
<header class="bg-dark text-white p-3">
<nav class="navbar navbar-expand-lg  navbar-light bg-dark">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
            <ul class="navbar-nav ">
                <li class="nav-item ">
                    <a class="nav-link text-light" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="/produtos">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="/fornecedores">Suppliers</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
    <div id="app" class="d-flex justify-content-center bg-secondary">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
    @vite('resources/js/bootstrap.js')
</body>
</html>