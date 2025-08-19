<?php

/**
 * Script to migrate profile images from old storage location to new public location
 * Run this once after updating the profile image upload logic
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\File;

echo "Starting profile image migration...\n";

$oldPath = public_path('storage/images');
$newPath = public_path('images');

// Create new directory if it doesn't exist
if (!File::exists($newPath)) {
    File::makeDirectory($newPath, 0755, true);
    echo "Created new images directory: {$newPath}\n";
}

$migratedCount = 0;
$errorCount = 0;

// Get all users with profile images
$users = User::whereNotNull('image')->get();

foreach ($users as $user) {
    $oldImagePath = $oldPath . '/' . basename($user->image);
    $newImagePath = $newPath . '/' . basename($user->image);

    if (File::exists($oldImagePath)) {
        try {
            // Copy file to new location
            File::copy($oldImagePath, $newImagePath);

            // Update database path (remove 'images/' prefix since it will be added in the asset() call)
            $user->update(['image' => 'images/' . basename($user->image)]);

            echo "Migrated: {$user->name} - " . basename($user->image) . "\n";
            $migratedCount++;

        } catch (Exception $e) {
            echo "Error migrating {$user->name}: " . $e->getMessage() . "\n";
            $errorCount++;
        }
    } else {
        echo "Image not found for {$user->name}: {$oldImagePath}\n";
        $errorCount++;
    }
}

echo "\nMigration completed!\n";
echo "Successfully migrated: {$migratedCount} images\n";
echo "Errors: {$errorCount}\n";

if ($migratedCount > 0) {
    echo "\nNote: You can now safely remove the old images from: {$oldPath}\n";
    echo "After testing, run: rm -rf " . $oldPath . "\n";
}

echo "\nDone!\n";
