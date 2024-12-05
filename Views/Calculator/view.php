<?php


// Other PHP logic
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>


<!DOCTYPE html>
<html lang="<?= $language ?>">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Red-Team/css/styles.css">


    <title>Inventory List</title>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }


        .main-content {
            margin-left: 320px;
            /* This can be adjusted to fit your sidebar width */
            padding: 40px;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }


        .header h1 {
            font-size: 2em;
            display: flex;
            align-items: center;
        }


        .header h1 img {
            margin-right: 10px;
            width: 50px;
        }





        .box2-main-form-div {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
        }


        h2 {
            text-align: center;
            margin-bottom: 20px;
        }


        .form-group {
            margin-bottom: 15px;
        }


        label {
            display: block;
            margin-bottom: 5px;
        }


        input[type="text"] {
            width: 700px; /* Fixed width for consistency */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }


        button {
            background-color: #ffc107;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }


        button:hover {
            background-color: #e0a800;
        }


        .results,
        .error {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .error {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffe6e6;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: red;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.8em;
            justify-content: flex-end;
            color: #888;
        }

        .box-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            /* Adds space between rows */
        }

        .row {
            display: flex;
            justify-content: space-between;
            /* Aligns Form 1 and Results side by side */
            gap: 20px;
            /* Adds space between Form 1 and Results */
        }

        .box {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            padding: 20px;
        }

        .box h2 {
            text-align: center;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
    </style>
</head>


<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>


    </div>

    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> CALCULATOR </h1>
        </div>


        <div class="box-container">
            <!-- Row for Form 1 and Results -->
            <div class="row">
                <!-- Form 1 -->
                <div class="box">
                    <form method="post" action="<?= $basePath ?>/<?= $language ?>/calculator/calculate">
                        <!--<h2>Form 1</h2>-->
                        <div class="form-group">
                            <label for="length"><?= LENGTH ?>:</label>
                            <input type="text" id="length" name="length" value="<?= isset($length) ? htmlspecialchars($length) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="height"><?= HEIGHT ?>:</label>
                            <input type="text" id="height" name="height" value="<?= isset($height) ? htmlspecialchars($height) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="thickness"><?= THICKNESS_OF_WALL ?>:</label>
                            <input type="text" id="thickness" name="thickness" value="<?= isset($thickness) ? htmlspecialchars($thickness) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="spacing"><?= SPACING_BETWEEN_WALL ?>:</label>
                            <input type="text" id="spacing" name="spacing" value="<?= isset($spacing) ? htmlspecialchars($spacing) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="load_bearing"><?= LOAD_BEARING ?>:</label>
                            <input type="text" id="load_bearing" name="load_bearing" value="<?= isset($load_bearing) ? htmlspecialchars($load_bearing) : '' ?>" required>
                        </div>
                        <button type="submit"><?= GENERATE ?></button>
                    </form>
                </div>

                <!-- Results Section -->
                <div class="box">
                    <h2>Results</h2>
                    <div style="background-color: #fdf8e2; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                        <div class="form-group">
                            <label for="wool_needed" style="display: block; font-weight: bold; margin-bottom: 5px;">Amount of Wool Needed</label>
                            <input type="text" id="wool_needed" name="wool_needed" value="<?= isset($results['wool_needed']) ? htmlspecialchars($results['wool_needed']) : '' ?>" readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff;">
                        </div>
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="planks_needed" style="display: block; font-weight: bold; margin-bottom: 5px;">Amount of Planks Needed</label>
                            <input type="text" id="planks_needed" name="planks_needed" value="<?= isset($results['planks_needed']) ? htmlspecialchars($results['planks_needed']) : '' ?>" readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row for Form 3 -->
            <div class="row">
                <!-- Form 3 -->
                <div class="box" style="width: 100%;">
                    <form method="post" action="<?= $basePath ?>/<?= $language ?>/calculator/calculate">
                       <!-- <h2>Form 3</h2> -->
                        <div class="form-group">
                          <!--  <label for="input_3_1"><?= INPUT_3_LABEL_1 ?>:</label>
                            <input type="text" id="input_3_1" name="input_3_1" required> -->
                        </div>
                        <div class="form-group">
                             <!--<label for="input_3_2"><?= INPUT_3_LABEL_2 ?>:</label>
                            <input type="text" id="input_3_2" required> -->
                        </div>
                      <!--  <button type="submit"><?= GENERATE ?></button> -->
                    </form>
                </div>
            </div>
        </div>







       





</body>


</html>
