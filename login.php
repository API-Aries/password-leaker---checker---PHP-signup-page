<!DOCTYPE html>
<html>
<head>
    <title>Login Form Example - API Aries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
            text-align: center;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            color: #555555;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: left;
            color: #333333;
            margin-top: 10px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .powered-by {
            margin-top: 20px;
            font-size: 12px;
            color: #888888;
        }
        .powered-by a {
            color: #4CAF50;
            text-decoration: none;
        }
        .powered-by a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <div class="message">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $apiToken = '111-111-111-111-111'; // API Token here ##### find here: https://dashboard.api-aries.online/
                    $apiUrl = 'https://api.api-aries.online/v1/checkers/pwned-password/?password=' . urlencode($password);

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'APITOKEN: ' . $apiToken
                    ));

                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        echo '<p class="error">Error:' . curl_error($ch) . '</p>';
                    } else {
                        $result = json_decode($response, true);
                        if (isset($result['error'])) {
                            echo '<p class="error">Error: ' . $result['error'] . '</p>';
                        } else {
                            if ($result['found']) {
                                echo '<p class="error">This password has been found ' . $result['used_times'] . ' times and is not safe to use.</p>';
                            } else {
                                echo '<p class="success">Password is safe. Proceeding with login for user: ' . htmlspecialchars($username) . '</p>';
                                
                                // Here you would typically check the username and password against your user database
                                // For example:
                                // $user = getUserFromDatabase($username);
                                // if ($user && password_verify($password, $user['password'])) {
                                //     echo '<p>Login successful!</p>';
                                // } else {
                                //     echo '<p class="error">Invalid username or password.</p>';
                                // }
                            }
                        }
                    }

                    curl_close($ch);
                }
                ?>
            </div>

            <button type="submit">Login</button>
        </form>
        <div class="powered-by">
            Powered by <a href="https://api-aries.online">API Aries</a>
        </div>
    </div>
</body>
</html>
