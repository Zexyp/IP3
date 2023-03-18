<?php

use Core\Providers\PDOProvider;

class User {
    private static string $table = 'user';

    public int $user_id;
    public ?string $username;
    public ?string $password;
    public ?string $has_rights;

    public static function exists($user_id) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function get_login($username, $password) : ?User {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE username = :username AND password = :password';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username, ':password' => $password]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function get($user_id) : ?User {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function get_all() : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->query('SELECT * FROM `' . self::$table . '`');
        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    private static function instance_from_data($data) : User {
        $user = new User();
        $user->user_id = $data['user_id'];
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->has_rights = $data['rights'];
        return $user;
    }
}
