<?php

// Intentionally vulnerable example for SAST demos.
// Do NOT use this pattern in real applications.

// Capture an "id" parameter directly from the query string.
$id = $_GET['id'] ?? '';

// Very old-style MySQL connection (for demonstration only).
// In a real app you would use PDO or mysqli with prepared statements.
$conn = mysql_connect('localhost', 'demo_user', 'demo_password');
mysql_select_db('demo_app', $conn);

// UNSAFE: Directly concatenating user input into the SQL string.
// This should be flagged by SAST tools as SQL injection.
$sql = "SELECT id, name, email FROM users WHERE id = " . $id;
$result = mysql_query($sql, $conn);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vulnerable User Lookup</title>
</head>
<body>
    <h1>Vulnerable User Lookup</h1>

    <form method="get" action="vulnerable.php">
        <label>
            User ID:
            <input type="text" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
        </label>
        <button type="submit">Lookup</button>
    </form>

    <h2>Debug SQL</h2>
    <pre><?php echo $sql; ?></pre>

</body>
</html>

