<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
        }
        
        .login-image {
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .login-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
        }
        
        .form-control-user {
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        
        .btn-user {
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
        }
        
        @media (max-width: 767.98px) {
            .login-image {
                height: 300px !important;
            }
            
            .vh-100 {
                height: auto !important;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>