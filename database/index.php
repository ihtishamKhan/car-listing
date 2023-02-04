<?php
    include_once '../conn/index.php';

    function hashPassword($password) {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    // Create car table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS car (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        model VARCHAR(30) NOT NULL,
        reg_no VARCHAR(30) NOT NULL,
        color VARCHAR(30) NOT NULL,
        price INT(30) NOT NULL,
        `condition` VARCHAR(30) NOT NULL,
        stock INT(30) NOT NULL,
        mileage INT(30) NOT NULL,
        image VARCHAR(30) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $result = mysqli_query($conn, $sql);

    // Create users table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $result = mysqli_query($conn, $sql);

    // Recent viewed cars
    $sql = "CREATE TABLE IF NOT EXISTS recent_viewed (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        car_id INT(6) UNSIGNED NOT NULL REFERENCES car(id),
        user_id INT(6) UNSIGNED NOT NULL REFERENCES users(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        -- when same user_id and car_id is added, it will be updated
        UNIQUE (car_id, user_id),
        FOREIGN KEY (car_id) REFERENCES car(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully" . "<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";
    }

    $sql = "INSERT INTO car (name, model, reg_no, color, price, `condition`, stock, mileage, image) VALUES 
            ('2023 Buick Envision', 'Buick', 'KCA 123', 'Black', 490000, 'New', 10, 1000, './assets/images/image-1.jpg'),
            ('2023 Cadillac Escalade', 'Cadillac', 'KCA 124', 'White', 'Used', 200000, 20, 2000, './assets/images/image-2.jpg'),
            ('2023 Chevrolet Camaro', 'Chevrolet', 'KCA 125', 'Red', 394000, 'New', 30, 3000, './assets/images/image-3.jpg'),
            ('2023 GMC Sierra', 'GMC', 'KCA 126', 'Blue', 400000, 'Used', 40, 4000, './assets/images/image-4.jpg'),
            ('2023 Hummer EV', 'Hummer', 'KCA 127', 'Green', 500000, 'New', 50, 5000, './assets/images/image-5.jpg'),
            ('2023 Pontiac Firebird', 'Pontiac', 'KCA 128', 'Yellow', 600000, 'Used', 60, 6000, './assets/images/image-6.jpg'),
            ('2023 Saturn Sky', 'Saturn', 'KCA 129', 'Orange', 704000, 'New', 70, 7000, './assets/images/image-7.jpg'),
            ('2023 Buick Envision', 'Buick', 'KCA 130', 'Black', 801000, 'Used', 80, 8000, './assets/images/image-8.jpg'),
            ('2023 Cadillac Escalade', 'Cadillac', 'KCA 131', 'White', 908000, 'New', 90, 9000, './assets/images/image-9.jpg'),
            ('2023 Chevrolet Camaro', 'Chevrolet', 'KCA 132', 'Red', 14900000, 'Used', 100, 10000, './assets/images/image-10.jpg')";
    // $result = mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully" . "<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";
    }

    $hashPassword = hashPassword('password');
    // add data to users table with password hashed using bcrypt
    $sql = "INSERT INTO users (name, email, password) VALUES ('John Doe', 'john@gmail.com', '$hashPassword')";

    if (mysqli_query($conn, $sql)) {
        echo "Test data added successfully";
    } else {
        echo "Error adding test data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
?>