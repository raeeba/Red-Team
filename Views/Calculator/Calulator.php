<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=" viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
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
            width: 100%;
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
    <div class="container">
        <h2>Calculator</h2>

        <form method="post" action="">
            <div class="form-group">
                <label for="length">Length:</label>
                <input type="text" id="length" name="length" required>
            </div>

            <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" id="height" name="height" required>
            </div>

            <div class="form-group">
                <label for="thickness">Thickness:</label>
                <input type="text" id="thickness" name="thickness" required>
            </div>

            <div class="form-group">
                <label for="spacing">Spacing:</label>
                <input type="text" id="spacing" name="spacing" required>
            </div>

            <div class="form-group">
                <label for="load_bearing">Load Bearing:</label>
                <input type="text" id="load_bearing" name="load_bearing" required>
            </div>

            <button type="submit">Generate</button>

            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <?php if (isset($results)): ?>
                <div class="results">
                    <h2>Results</h2>
                    <p>Amount of Wool Needed: <?= number_format($results['wool_needed'], 2) ?> cubic meters</p>
                    <p>Amount of Planks Needed: <?= $results['planks_needed'] ?> planks</p>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
