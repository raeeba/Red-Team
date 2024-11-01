
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
        <title>Inventory</title>

        <link rel="stylesheet" href="/Red-Team/css/style.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>

    <!--  <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">-->
    </head>

    <body class="mp-body">

        <div class="main-body">
            <div class="box1">Box 1 (smaller)</div>

            <div class="box2">

                <div class="box2-back">
                    <div class="box2-back-icon">

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" stroke="currentColor" stroke-width="1.5" />
                            </svg>

                            Back to Inventory

                        </a>
                    </div>

                </div>
                <div class="box2-heading">
                    <div class="box2-heading-icon">
                        <svg class="box2-heading-icon-svg" xmlns="http://www.w3.org/2000/svg" cwidth="30" height="30" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                            <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z" />
                        </svg>

                        MODIFY PRODUCT

                    </div>

                </div>
                <div class="box2-main">

                    <div class="box2-main-form-div">

                        <form action="/submit-form" method="POST">
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modify-regular-div">
                                <label for="name" class="form-label">Name</label>
                                <br>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>


                            <button type="submit" class="modify-regular-div-button">Add Product</button>
                        </form>

                    </div>
                </div>


            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>