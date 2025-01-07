<?php
     session_start();
     unset($_SESSION['startTime']);
     setCookie('valorClientToken', '', time() - 5, '/');
     setCookie('valorAmount', '', time() - 5,  '/');
     setCookie('valorEpi', '', time() - 5, '/');
     setCookie('valorAppId', '', time() - 5, '/');
     setCookie('valorAppKey', '', time() - 5, '/');


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel = "icon" href ="./images/valorlogo.ico" type="image/x-icon">
    <title>VALOR PAYTECH</title>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="./valorlogo.png" />
        </div>
        <div class="content">
            <div class="right-side">
                <div class="topic-text">To Test Passage.js Demo</div>
                <form id="valorpay-app" action="" method="post">
                    <div class="input-box">
                        <input type="text" placeholder="Enter APP ID" id="app-id" name="appid" maxlength="40" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Enter API KEY" id="app-key" name="appkey" maxlength="40" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Enter EPI" id="epi-id" name="epi" maxlength="10" min="0" required style="-moz-appearance: textfield;">
                    </div>
                    <div class="input-icon input-box">
                        <input type="text" id="amount" name="amount" required style="-moz-appearance: textfield;" oninput="formatValue()" onblur="formatValue()"
                         value="0.00">
                        <i>$</i>
                    </div>
                    <div class="button" style="display: flex; justify-content: center;">
                        <input type="submit" value="Submit" id="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/valorpay.js"></script>
</body>

</html>