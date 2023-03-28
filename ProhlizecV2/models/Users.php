<?php

use Browse\Providers\PDOProvider;

class Users {
    private static string $table = 'user';

    public ?int $user_id = null;
    public ?string $username = null;
    public ?string $password = null;
    public ?string $has_rights = null;

    public static function exists(int $user_id) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function exists_username(string $username) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE username = :username';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function get_login(string $username, string $password) : ?Users {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE username = :username AND password = :password';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username, ':password' => $password]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function get(int $user_id) : ?Users {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function get_all_username(string $username) : array {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE username = :username';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username]);

        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function get_all(?array $order = null) : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->query('SELECT * FROM `' . self::$table . '`' .
            ($order != null ? OrderBuilder::build($order) : ''));
        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function create(Users $user): Users {
        $pdo = PDOProvider::get();

        $query = 'INSERT INTO `' . self::$table . '` (username, password) VALUES (:username, :password, :rights)';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'username' => $user->username,
            'password' => $user->password,
            'rights' => $user->has_rights,
        ]);

        return self::get($pdo->lastInsertId());
    }

    public static function update(Users $user) {
        $pdo = PDOProvider::get();

        $query = 'UPDATE `' . self::$table . '` SET username = :username, password = :password, rights = :rights WHERE user_id = :user_id';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'user_id' => $user->user_id,
            'username' => $user->username,
            'password' => $user->password,
            'rights' => $user->has_rights,
        ]);
    }

    public static function delete(int $user_id) {
        $query = 'DELETE FROM `' . self::$table . '` WHERE user_id = :user_id';

        $pdo = PDOProvider::get();

        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
    }

    private static function instance_from_data(array $data) : Users {
        $user = new Users();
        $user->user_id = $data['user_id'];
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->has_rights = $data['rights'];
        return $user;
    }
}
