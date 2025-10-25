<?php
// Debug login issue
echo "<h2>Login Debug Test</h2>";

try {
    // Connect to database
    $pdo = new PDO('mysql:host=localhost;dbname=lms_maranan', 'root', '');
    echo "✓ Database connection successful<br>";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Users table exists<br>";
        
        // Get all users
        $stmt = $pdo->query("SELECT id, name, email, role FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>All Users in Database:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
        
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['name']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['role']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test teacher login specifically
        echo "<h3>Testing Teacher Login:</h3>";
        $email = 'teacher@example.com';
        $password = 'teacher123';
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "✓ Teacher user found: {$user['name']}<br>";
            echo "✓ Email: {$user['email']}<br>";
            echo "✓ Role: {$user['role']}<br>";
            
            // Test password
            if (password_verify($password, $user['password'])) {
                echo "✓ Password verification: SUCCESS<br>";
                echo "<strong style='color: green;'>Login credentials are correct!</strong><br>";
            } else {
                echo "✗ Password verification: FAILED<br>";
                echo "<strong style='color: red;'>Password does not match!</strong><br>";
                
                // Show what the password hash looks like
                echo "Stored password hash: " . substr($user['password'], 0, 20) . "...<br>";
            }
        } else {
            echo "✗ Teacher user not found<br>";
            echo "<strong style='color: red;'>Teacher account does not exist!</strong><br>";
        }
        
    } else {
        echo "✗ Users table does not exist<br>";
    }
    
} catch (PDOException $e) {
    echo "✗ Database error: " . $e->getMessage() . "<br>";
}

echo "<br><h3>Test Login URLs:</h3>";
echo "<a href='public/login'>Go to Login Page</a><br>";
echo "<a href='public/announcements'>Go to Announcements</a><br>";
?>
