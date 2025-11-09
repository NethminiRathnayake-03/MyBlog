<?php
// db_sample.php
// Safe sample database connection file for publishing on GitHub.

// Detect if running on local (XAMPP) or online (hosting)
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Localhost (XAMPP) - replace with your local DB values if needed
    $host = "localhost";
    $dbname = "blogdb";    
    $username = "root";       
    $password = "";            
} else {
    // Online (InfinityFree) - PLACEHOLDERS only (do NOT publish real credentials)
    $host = "sql207.infinityfree.com";
    $dbname = "if0_40347683_blogDB";    
    $username = "if0_40347683"; 
    $password = "my_password_here";  
}

try {
    // Note: this file is only for demonstration on GitHub.
    // On my actual server I have kept the real includes/db.php (not uploaded).
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected (sample) successfully";
} catch (PDOException $e) {
   
    echo "Database connection (sample) not active. Replace placeholders with real values.";
}
?>
