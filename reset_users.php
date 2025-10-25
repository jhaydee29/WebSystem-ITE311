<?php
// Reset and recreate users
echo "<h2>Resetting Users</h2>";

try {
    // Connect to database
    $pdo = new PDO('mysql:host=localhost;dbname=lms_maranan', 'root', '');
    echo "✓ Database connection successful<br>";
    
    // Clear existing users
    $pdo->exec("DELETE FROM users");
    echo "✓ Cleared existing users<br>";
    
    // Create fresh users
    $users = [
        [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Renz Student',
            'email' => 'student@example.com',
            'password' => password_hash('student123', PASSWORD_DEFAULT),
            'role' => 'student',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Al-Muhyi Teacher',
            'email' => 'teacher@example.com',
            'password' => password_hash('teacher123', PASSWORD_DEFAULT),
            'role' => 'teacher',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($users as $user) {
        $stmt->execute([
            $user['name'],
            $user['email'],
            $user['password'],
            $user['role'],
            $user['created_at'],
            $user['updated_at']
        ]);
        echo "✓ Created user: {$user['name']} ({$user['email']}) - Role: {$user['role']}<br>";
    }
    
    echo "<br><h3>Verification - All Users:</h3>";
    $stmt = $pdo->query("SELECT id, name, email, role FROM users");
    $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    
    foreach ($allUsers as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test teacher password
    echo "<br><h3>Testing Teacher Password:</h3>";
    $stmt = $pdo->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->execute(['teacher@example.com']);
    $teacherData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($teacherData && password_verify('teacher123', $teacherData['password'])) {
        echo "✓ Teacher password verification: <strong style='color: green;'>SUCCESS</strong><br>";
    } else {
        echo "✗ Teacher password verification: <strong style='color: red;'>FAILED</strong><br>";
    }
    
    echo "<br><strong style='color: green;'>Users reset successfully! Try logging in now.</strong><br>";
    echo "<br><a href='public/login'>Go to Login Page</a>";
    
} catch (PDOException $e) {
    echo "✗ Database error: " . $e->getMessage() . "<br>";
}
?>
