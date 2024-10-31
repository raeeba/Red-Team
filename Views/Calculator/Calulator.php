<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .results {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .results p {
            margin-bottom: 10px;
        }
        .error {
            color: red;
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
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle the form submission here
            $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
            $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
            $thickness = filter_input(INPUT_POST, 'thickness', FILTER_VALIDATE_FLOAT);
            $spacing = filter_input(INPUT_POST, 'spacing', FILTER_VALIDATE_FLOAT);
            $load_bearing = filter_input(INPUT_POST, 'load_bearing', FILTER_VALIDATE_FLOAT);

            if ($length === false || $height === false || $thickness === false || 
                $spacing === false || $load_bearing === false) {
                echo "<p class='error'>Invalid input. Please ensure all fields are filled correctly.</p>";
            } else {
                $results = [];
                $results['wool_needed'] = calculate_wool_needed($length, $height, $thickness, $spacing, $load_bearing);
                $results['planks_needed'] = calculate_planks_needed($length, $height, $thickness, $spacing, $load_bearing);
                ?>

                <div class='results'>
                    <h2>Results</h2>
                    <p>Amount of Wool Needed: <?php echo number_format(htmlspecialchars($results['wool_needed']), 2); ?> cubic meters</p>
                    <p>Amount of Planks Needed: <?php echo htmlspecialchars($results['planks_needed']); ?> planks</p>
                </div>

                <?php
            }
        }

        function calculate_wool_needed($length, $height, $thickness, $spacing, $load_bearing) {
            $area = $length * $height;
            $volume_needed = $area * $thickness;
            return $volume_needed * (1 + $spacing / 100);
        }

        function calculate_planks_needed($length, $height, $thickness, $spacing, $load_bearing) {
            $area = $length * $height;
            $plank_width = 0.1; // Example width of a plank
            $plank_area = $plank_width * $thickness;
            $num_planks = ceil($area / $plank_area);
            return ceil($num_planks * (1 + $spacing / 100));
        }
        ?>
    </div>
</body>
</html>