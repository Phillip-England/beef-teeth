<?php

function connect_db() {
    try {
        if (
            !isset($_ENV["DB_HOST"]) ||
            !isset($_ENV["DB_USERNAME"]) ||
            !isset($_ENV["DB_PASSWORD"]) ||
            !isset($_ENV["DB_NAME"])
        ) {
            throw new Exception('missing database ENV variables');
        }
        $mysqli = mysqli_init();
        $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
        $mysqli->real_connect($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
        if ($mysqli->connect_errno) {
            throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
        return [$mysqli, null];
    } catch (Exception $e) {
        return [null, $e];
    }
}

function db_show_tables($mysqli) {
    $query = "SHOW TABLES";
    $result = $mysqli->query($query);
    if ($result) {
        $tables = $result->fetch_all(MYSQLI_NUM);
        if (!empty($tables)) {
            echo "Tables in the database:\n";
            foreach ($tables as $table) {
                echo "- $table[0]\n";
            }
        } else {
            echo "No tables found in the database.\n";
        }
        $result->close();
    } else {
        echo "Error fetching tables: " . $mysqli->error;
    }
}

function create_user_table($mysqli) {
    try {
        $query = "CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            language VARCHAR(255) NOT NULL
        )";
        $mysqli->query($query);
        return null;
    } catch (Exception $e) {
        return $e;
    }
}

function delete_all_tables($mysqli) {
    try {
        $query = "SHOW TABLES";
        $result = $mysqli->query($query);
        if ($result) {
            $tables = $result->fetch_all(MYSQLI_NUM);
            $result->close();
            if (!empty($tables)) {
                foreach ($tables as $table) {
                    $tableName = $table[0];
                    $dropQuery = "DROP TABLE IF EXISTS $tableName";
                    $mysqli->query($dropQuery);
                }
            }
        }
        return null;
    } catch (Exception $e) {
        return $e;
    }
}

?>