<?php
$host = 'mysql';
$db = 'db_tournament';
$user = 'my_user';
$pass = 'my_password';

echo "<h1>PHP Connection Test</h1>";

// Test 1: Check if PDO is available
if (extension_loaded('pdo_mysql')) {
    echo "<p style='color:green;'>✅ PDO MySQL extension is loaded</p>";
} else {
    echo "<p style='color:red;'>❌ PDO MySQL extension is NOT loaded</p>";
}

// Test 2: Try PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green;'>✅ PDO: Successfully connected to MySQL!</p>";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT 'PDO is working!' as message");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p style='color:green;'>✅ PDO Query Result: " . $result['message'] . "</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red;'>❌ PDO Connection Failed: " . $e->getMessage() . "</p>";
}

// Test 3: Try MySQLi connection (for comparison)
try {
    $mysqli = new mysqli($host, $user, $pass, $db);
    if ($mysqli->connect_error) {
        throw new Exception($mysqli->connect_error);
    }
    echo "<p style='color:green;'>✅ MySQLi: Successfully connected to MySQL!</p>";
    $mysqli->close();
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ MySQLi Connection Failed: " . $e->getMessage() . "</p>";
}

// Show all loaded extensions
echo "<h2>Loaded PHP Extensions:</h2>";
echo "<ul>";
foreach (get_loaded_extensions() as $ext) {
    if (strpos($ext, 'mysql') !== false || strpos($ext, 'pdo') !== false) {
        echo "<li><strong>$ext</strong></li>";
    } else {
        echo "<li>$ext</li>";
    }
}
echo "</ul>";
?>