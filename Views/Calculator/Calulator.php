<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h2>Calculator</h2>

        <form method="post" action="">
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
</body>
</html>
