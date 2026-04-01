<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Aplikasi Kasir</h2>
            
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchTab('login')" data-tab="login">Login</button>
                <button class="tab-btn" onclick="switchTab('register')" data-tab="register">Registrasi</button>
            </div>

            <!-- LOGIN TAB -->
            <div id="login-content" class="tab-content active">
                <div id="login-alert"></div>
                <form onsubmit="handleLogin(event)" id="login-form">
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input type="text" id="login-username" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
                <p style="text-align: center; margin-top: 20px; font-size: 12px; color: #7f8c8d;">
                    <strong>Demo Account:</strong><br>
                    Username: admin / Password: admin123<br>
                    Username: petugas / Password: petugas123
                </p>
            </div>

            <!-- REGISTER TAB -->
            <div id="register-content" class="tab-content">
                <div id="register-alert"></div>
                <form onsubmit="handleRegister(event)" id="register-form">
                    <div class="form-group">
                        <label for="register-nama">Nama Lengkap</label>
                        <input type="text" id="register-nama" required>
                    </div>
                    <div class="form-group">
                        <label for="register-username">Username</label>
                        <input type="text" id="register-username" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <input type="password" id="register-password" required>
                    </div>
                    <button type="submit" class="btn">Daftar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
