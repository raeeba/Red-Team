<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        
        .main-content {
            margin-left: 320px; /* Adjust this margin to make space for the sidebar */
            padding: 40px;
        }

        .container {
            width: 600px; /* Adjust as needed for your desired width */
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            width: 90%;
            padding: 10px;
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

        .results, .error {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .error {
            color: red;
            background-color: #ffe6e6;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>
</div>

<div class="main-content">
    <div class="container">
        <h2>Calculator</h2>

        <form method="post" action="<?= $basePath ?>/<?=$language?>/calculator/calculate">
            <div class="form-group">
                <label for="length">Length:</label>
                <input type="text" id="length" name="length" value="<?= isset($length) ? htmlspecialchars($length) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" id="height" name="height" value="<?= isset($height) ? htmlspecialchars($height) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="thickness">Thickness:</label>
                <input type="text" id="thickness" name="thickness" value="<?= isset($thickness) ? htmlspecialchars($thickness) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="spacing">Spacing:</label>
                <input type="text" id="spacing" name="spacing" value="<?= isset($spacing) ? htmlspecialchars($spacing) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="load_bearing">Load Bearing:</label>
                <input type="text" id="load_bearing" name="load_bearing" value="<?= isset($load_bearing) ? htmlspecialchars($load_bearing) : '' ?>" required>
            </div>

            <button type="submit">Generate</button>

            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (isset($results)): ?>
                <div class="results">
                    <h2>Results</h2>
                    <p>Amount of Wool Needed: <?= htmlspecialchars($results['wool_needed']) ?> cubic meters</p>
                    <p>Amount of Planks Needed: <?= htmlspecialchars($results['planks_needed']) ?> planks</p>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

</body>
</html>
