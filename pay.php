<?php
$clientToken = '';
$amount = 0;
$epiId = 0;
if(isset($_COOKIE['valorClientToken'])) {
    $clientToken = $_COOKIE['valorClientToken'];
}
if(isset($_COOKIE['valorAmount'])) {
    $amount = $_COOKIE['valorAmount'];
}
if(isset($_COOKIE['valorEpi'])) {
    $epiId = $_COOKIE['valorEpi'];
}
?>
<?php
if($clientToken){
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VALOR PAYTECH</title>
    </head>
    <body>
        <div class="container">
        <div style="background-color: #0C4F9D; color: white; padding: 10px; width: 12%; text-align: center; float: right;">
            <span id="countdown"></span>
        </div>
            <div class="content">
                <div class="right-side">
                    <form method="post" action="sale_api.php" id="valor-checkout-form" class="checkout-form-test">
                        <input type="hidden" value="<?php echo $amount ?>" />
                        <div id="valor-fields"></div>
                    </form>
                </div>
            </div>
        </div>
        <script src="./js/Passage.js" data-variant="inline" data-clientToken="<?php echo $clientToken;?>" data-epi="<?php echo $epiId;?>" 
            data-email="true" data-phone="true"
            data-billingAddress="true" data-valor-logo="true" data-name="valor_passage"
            data-googlePay="false" data-cardholdername="true" data-ach="true"
            data-submitText="Buy Now" data-submitBg="#005cb9" data-submitColor="#fff" data-demo="true"></script>
    </body>
<?php
}
?>
     <script src="./js/pay.js"></script>
    </html>
