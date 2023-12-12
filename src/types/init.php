<?php


abstract class DbController {
    public function insert($mysqli) {
        exit('Default implementation for Dbcontroller.insert()');
    }

    public function loadAll($mysqli) {
        exit('Default implementation for DbController.loadAll()');
    }

    public function getById($mysqli, $userId) {
        exit('Default implementation for DbController.getById()');
    }
}

// takes a DbController and calls insert on it
function db_insert($mysqli, DbController $controller) {
    $err = $controller->insert($mysqli);
    if ($err != null) {
        return $err;
    }
    return null;
}

// takes a DbController and calls loadAll on it
function db_load_all($mysqli, DbController $controller) {
    $err = $controller->loadAll($mysqli);
    if ($err != null) {
        return $err;
    }
    return null;
}

// takes a DbController and calls getById on it
function db_get_by_id($mysqli, DbController $controller, $userId) {
    $err = $controller->getById($mysqli, $userId);
    if ($err != null) {
        return $err;
    }
    return null;
}



// responsible for handling a single user
class User extends DbController {
    public ?int $id;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $email;
    public ?string $language;
    public ?string $password;
    public function insert($mysqli) {
        try {
            if ($this->firstName == null || $this->lastName == null || $this->email == null || $this->password == null || $this->language == null) {
                throw new Exception('User.insert() requires firstName, lastName, email, password, and language');
            }
            $stmt = $mysqli->prepare("INSERT INTO user (first_name, last_name, email, password, language) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $this->firstName, $this->lastName, $this->email, $this->password, $this->language);
            if (!$stmt->execute()) {
                throw new Exception("Error inserting user: " . $stmt->error);
            }
            $this->id = $stmt->insert_id;
            $stmt->close();
            return null;
        } catch (Exception $e) {
            return $e;
        }
    }
    public function getById($mysqli, $userId) {
        try {
            $stmt = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
            $stmt->bind_param("i", $userId);
            if (!$stmt->execute()) {
                throw new Exception("Error fetching user: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                throw new Exception("User with ID $userId not found.");
            }

            $user = $result->fetch_assoc();
            $this->id = $user['id'];
            $this->firstName = $user['first_name'];
            $this->lastName = $user['last_name'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->language = $user['language'];

            $stmt->close();
            return null;
        } catch (Exception $e) {
            return $e;
        }
    }
}

// responsible for handling groups of users
class UserRepository extends DbController {
    public function loadAll($mysqli) {
        try {
            $users = [];
            $result = $mysqli->query("SELECT * FROM user");
            while ($row = $result->fetch_assoc()) {
                $user = new User();
                $user->id = $row['id'];
                $user->firstName = $row['first_name'];
                $user->lastName = $row['last_name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->language = $row['language'];
                $users[] = $user;
            }
            return [$users, null];
        } catch (Exception $e) {
            return [null, $e];
        }
    }
}

?>