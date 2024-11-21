
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Modify Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 320px; 
            padding: 40px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5em;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .header h1 img {
            margin-right: 10px;
            width: 50px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="date"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container .actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .form-container .actions button {
            background-color: #ffb84d;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .form-container .actions button:hover {
            background-color: #e69d3c;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
<div class="logo">
    <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    <h1>AMO & LINAT</h1>
</div>

<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1><img src="employee-icon.png" alt="Modify Employee Icon">MODIFY EMPLOYEE</h1>
    </div>

    <!-- Modify Employee Form -->
    <div class="form-container">
        <form action="<?=$basePath?>/<?=$language?>/user/updateSave/<?= htmlspecialchars($user->email) ?>" method="POST">
            <input name="email" type="hidden" value="<?= htmlspecialchars($user->email) ?>">

            <label><?=NAME?>:</label>
            <input name="name" value="<?= htmlspecialchars($user->name) ?>">

            <label><?=BIRTHDAY?>:</label>
            <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user->birthday) ?>">

            <label><?=ADMIN_TYPE?>:</label>
<select name="role" id="role">
    <option value="admin" <?php echo (isset($user->role) && $user->role == 'admin') ? 'selected' : ''; ?>>Admin</option>
    <option value="super admin" <?php echo (isset($user->role) && $user->role == 'super admin') ? 'selected' : ''; ?>>Super Admin</option>
</select>

            <!-- Actions -->
            <div class="actions">
                <button type="submit"><?=SAVE_UPDATE?></button>
                <a href="<?=$basePath?>/<?=$language?>/user/list"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>AMO & LINAT - <?=ALL_RIGHTS?></p>
</div>

<script>
    document.querySelector("form").addEventListener("submit", function (event) {
        const roleSelect = document.getElementById("role");
        const selectedRole = roleSelect.value;

        if (selectedRole === "super admin") {
            console.log("Granting Super Admin with Admin access...");
        }
    });



    const today = new Date();
    const minDate = new Date(today.getFullYear() - 80, today.getMonth(), today.getDate());

    // Format dates as YYYY-MM-DD
    const maxDateStr = today.toISOString().split('T')[0];
    const minDateStr = minDate.toISOString().split('T')[0];

    const birthdayInput = document.getElementById('birthday');
    birthdayInput.max = maxDateStr;
    birthdayInput.min = minDateStr;
</script>
</body>
</html>
