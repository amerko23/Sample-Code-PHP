<?php
     session_start();
     unset($_SESSION['startTime']);
     setCookie('valorClientToken', '', time() - 5, '/');
     setCookie('valorAmount', '', time() - 5,  '/');
     setCookie('valorEpi', '', time() - 5, '/');
     setCookie('valorAppId', '', time() - 5, '/');
     setCookie('valorAppKey', '', time() - 5, '/');
     if (isset($_SESSION['response'])) {
          $data = json_decode($_SESSION['response']);
       }
     header('refresh:10;URL=/passage/');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VALOR PAYTECH</title>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="./valorlogo.png" />
        </div>
        <div class="content">
            <div class="right-side">
                <div class="topic-text">OOPS.</div>
                <section class="section-background" style="display: flex; justify-content: center; text-align: center">
                        <div class="about-info">
                        <div class="about-info">
                            <h4>Something went wrong.</h4>
                            <p>Error NO : <?php echo $data->error_code; ?></p>
                            <p>Error Code : <?php echo $data->error_code; ?></p>
                            <p>Transaction Status : <?php echo $data->mesg; ?></p>
                        </div>
                </section>
                <div class="button" style="display: flex; justify-content: center">
                    <a href="/passage">
                        <input type="submit" value="Home" id="home">
                    </a>
                </div>
                <p style="text-align: center;">This Page Automatically redirect in <span id="timer"></span> Second.</p>
                    <script>
                        function countdown(num) {
                            document.getElementById("timer").innerHTML = num;
                            if(num > 0) {
                            setTimeout(function() {
                                countdown(num - 1);
                            }, 1000); // Delay the countdown by 1 second
                        }
                        }
                    </script>
            </div>
        </div>
    </div>
    <script>
		countdown(10)
	</script>
</body>
</html>