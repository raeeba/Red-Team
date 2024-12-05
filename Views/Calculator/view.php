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

        form {
            flex: 1; /* Form takes up one part of the available space */
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

        .results {
    flex: 1; /* Allow it to take part of the available space */
    margin-left: 20px; /* Space between the form and results */
    padding: 20px;
    background-color: #f8f9fa;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 300px; /* Set a fixed width to make it less wide */
    box-sizing: border-box; /* Ensure padding doesn't affect width */
    align-self: flex-start; /* Align the results to the top of the form */
}

        .results h2 {
            margin-top: 0;
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

        <div class="box2-main-form-div">
            <!-- Form Section -->
            <form method="post" action="<?= $basePath ?>/<?=$language?>/calculator/calculate">
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

                <?php if (isset($error)): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
            </form>

            <!-- Results Section -->
            <?php if (isset($results)): ?>
                <div class="results">
                    <h2><?= RESULTS ?></h2>
                    <p><?= AMOUNT_OF_WOOL ?>: <?= htmlspecialchars($results['wool_needed']) ?> cubic meters</p>
                    <p><?= AMOUNT_OF_PLANKS ?>: <?= htmlspecialchars($results['planks_needed']) ?> planks</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

  
</body>

</html>
