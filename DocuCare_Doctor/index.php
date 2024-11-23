<!--for captcha-->
<?php
session_start();

// Generate a random string
$captcha_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

$_SESSION['captcha_code'] = $captcha_code;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocuCare Login</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-form">
        <div class="container">
            <div class="main">
                <div class="content">
                    <h2>Log In</h2>
                    <form method="POST" action="IndexScript.php">
                        <input type="text" name="Email" placeholder="Email">
                        <input type="password" name="Password" placeholder="Password">
                        <div class="captcha-container">
                            <label for="captchaInput">
                              Captcha:
                            </label>
                            <div class="captcha" id="captcha">
                                <strong><?php echo $captcha_code; ?></strong>
                            </div>
                            <div class="captcha-refresh">
                              <span class="captcha-refresh" id="refreshCaptcha">Refresh</span>
                            </div>
                        </div>
                          <div>
                            <input type="text" id="captcha" name="captcha" placeholder="Enter Captcha" required>
                          </div>
                          <input type="submit" id="login-btn" name="log_user" value="Login"/>
                    </form>
                     
                </div>
                <div class="form-img">
                    <img src="img/bg1.png" alt="">
                </div>
            </div>
        </div>
    </div>
</body>
</html>