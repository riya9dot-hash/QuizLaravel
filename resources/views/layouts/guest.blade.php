<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background: linear-gradient(180deg, #848177 0%, #000000 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .login-container {
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
                padding: 40px;
            }

            .login-header {
                text-align: center;
                margin-bottom: 30px;
            }

            .login-header h1 {
                color: #333;
                font-size: 28px;
                margin-bottom: 5px;
            }

            .login-header p {
                color: #666;
                font-size: 14px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                color: #333;
                font-size: 14px;
                font-weight: 500;
                margin-bottom: 8px;
            }

            .form-group input {
                width: 100%;
                padding: 12px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                transition: border-color 0.3s;
            }

            .form-group input:focus {
                outline: none;
                border-color: #848177;
            }

            .remember-me {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
            }

            .remember-me input {
                width: auto;
                margin-right: 8px;
            }

            .remember-me label {
                color: #666;
                font-size: 14px;
                font-weight: normal;
                margin: 0;
            }

            .btn-login {
                width: 100%;
                padding: 12px;
                background: linear-gradient(180deg, #848177 0%, #000000 100%);
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-login:active {
                transform: translateY(0);
            }

            .alert {
                padding: 12px;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: 14px;
            }

            .alert-success {
                background-color: #d4edda;
                border: 1px solid #c3e6cb;
                color: #155724;
            }

            .alert-error {
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                color: #721c24;
            }

            .alert ul {
                list-style: none;
                margin: 0;
                padding-left: 0;
            }

            .alert li {
                margin-bottom: 5px;
            }

            @media (max-width: 480px) {
                .login-container {
                    padding: 30px 20px;
                }

                .login-header h1 {
                    font-size: 24px;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-header">
                <h1>{{ config('app.name', 'Laravel') }}</h1>                
                <p>Sign in to your account</p>
            </div>
            
            {{ $slot }}
        </div>
    </body>
</html>
