<?php

echo "Checking PostgreSQL PHP Extension...\n";

if (extension_loaded('pdo_pgsql')) {
    echo "✅ PDO PostgreSQL extension is loaded\n";
} else {
    echo "❌ PDO PostgreSQL extension is NOT loaded\n";
    echo "Please install php-pgsql extension\n";
}

if (extension_loaded('pgsql')) {
    echo "✅ PostgreSQL extension is loaded\n";
} else {
    echo "❌ PostgreSQL extension is NOT loaded\n";
}

echo "\nAvailable PDO drivers:\n";
print_r(PDO::getAvailableDrivers());

echo "\nDone!\n";