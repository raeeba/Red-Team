@ -0,0 +1,40 @@
<?php
    //$basePath=dirname($_SERVER['PHP_SELF']);

    $basePath=dirname($_SERVER['PHP_SELF']);
    $language=isset($_GET['language']) ? $_GET['language'] : 'en' ;

?>

    <!DOCTYPE html>
    <html lang="<?= $language ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <link rel="stylesheet" href="/Red-Team/css/style.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">



        <!--  <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">-->
    </head>

    <body class="mp-body">

        <div class="main-body">NAVIGATION</div>

            <div class="box2">

                <div class="box2-back-icon">
                <a href="#" class="btn btn-light">
    <i class="bi bi-arrow-left"></i> Back
</a>
                </div>
                <div class="box2-back-title"></div>

                </div>
                <div class="box2-heading">Box 1 (smaller)</div>
                <div class="box2-main">Box 1 (smaller)</div>


            </>
        </div>

    </body>

    </html>