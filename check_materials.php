<?php
// Quick database check script
require_once 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "=== MATERIALS TABLE CHECK ===\n\n";

$query = $db->query("SELECT m.*, u.name as uploader_name, c.title as course_title 
                     FROM materials m 
                     LEFT JOIN users u ON m.uploaded_by = u.id 
                     LEFT JOIN courses c ON m.course_id = c.id");

$materials = $query->getResultArray();

if (empty($materials)) {
    echo "❌ No materials found in database.\n";
} else {
    echo "✅ Found " . count($materials) . " material(s):\n\n";
    foreach ($materials as $material) {
        echo "ID: " . $material['id'] . "\n";
        echo "Title: " . $material['title'] . "\n";
        echo "Course: " . $material['course_title'] . "\n";
        echo "Uploaded by: " . $material['uploader_name'] . "\n";
        echo "File: " . $material['file_name'] . "\n";
        echo "Path: " . $material['file_path'] . "\n";
        echo "Created: " . $material['created_at'] . "\n";
        echo "---\n";
    }
}

echo "\n=== FILE SYSTEM CHECK ===\n\n";
$uploadPath = FCPATH . 'uploads/materials/';
if (is_dir($uploadPath)) {
    echo "✅ Upload directory exists: " . $uploadPath . "\n";
    $files = scandir($uploadPath);
    $files = array_diff($files, ['.', '..']);
    if (empty($files)) {
        echo "❌ No files found in upload directory.\n";
    } else {
        echo "✅ Files in directory:\n";
        foreach ($files as $file) {
            echo "  - " . $file . "\n";
        }
    }
} else {
    echo "❌ Upload directory does not exist.\n";
}
