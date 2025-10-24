<?php
// Test database connection and setup
try {
    // Test connection
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "✓ MySQL connection successful\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE 'lms_maranan'");
    $database_exists = $stmt->rowCount() > 0;
    
    if ($database_exists) {
        echo "✓ Database 'lms_maranan' exists\n";
        
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=lms_maranan', 'root', '');
        
        // Check if users table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        $users_table_exists = $stmt->rowCount() > 0;
        
        if ($users_table_exists) {
            echo "✓ Users table exists\n";
            
            // Check if there are any users
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $user_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "✓ Users in database: $user_count\n";
            
            if ($user_count > 0) {
                // Show existing users
                $stmt = $pdo->query("SELECT id, name, email, role FROM users");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "\n--- Existing Users ---\n";
                foreach ($users as $user) {
                    echo "ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role']}\n";
                }
            }
        } else {
            echo "✗ Users table does not exist\n";
        }
    } else {
        echo "✗ Database 'lms_maranan' does not exist\n";
    }
    
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}
?>
