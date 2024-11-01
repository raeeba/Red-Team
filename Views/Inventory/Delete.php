<div?php
    //$basePath=dirname($_SERVER['PHP_SELF']);

    $basePath=dirname($_SERVER['PHP_SELF']);
    $language=isset($_GET['language']) ? $_GET['language'] : 'en' ;

    ?>

    <!DOCTYPE html>
    <html lang="<?= $language ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventory</title>

       <!-- <link rel="stylesheet" href="/Red-Team/css/style.css">-->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>

    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
    </head>

    <body class="mp-body">

        <div class="main-body">
            <div class="box1"> ADD THE NAVIGATION HERE</div>

            <div class="box2">
                ADD THE MAIN THINGS HERE
                EXAMPLE: INVENTORU TABLE


            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>