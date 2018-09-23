<?php

class User {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all() {
        return self::find_this_query("SELECT * FROM " . self::$db_table);
    }

    public static function find_by_id($user_id) {
        $the_result_array = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id = $user_id LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_this_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = self::instantiation($row);
        }
        return $the_object_array;
    }

    public static function verify_user($username, $password) {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "
            SELECT * 
            FROM 
                " . self::$db_table . " 
            WHERE username = '{$username}' 
            AND password = '{$password}' 
            LIMIT 1
        ";

        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }


    public static function instantiation($the_record) {
        $the_object = new self();

        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    private function has_the_attribute($the_attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

    protected function properties() {

//        return get_object_vars($this);
        $properties = array();
        foreach (self::$db_table_fields as $db_field) {
            // property_exists — オブジェクトもしくはクラスにプロパティが存在するかどうかを調べる
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties() {
        global $database;

        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "
            INSERT INTO
                " . self::$db_table . "
                (" . implode(",", array_keys($properties)) . ")
            VALUES
                ('" . implode("','", array_values($properties)) . "')
        ";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;

        $properties = $this->clean_properties();

        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key} = '{$value}'";
        }
        $id = $database->escape_string($this->id);

        $sql = "
            UPDATE
                " . self::$db_table . "
            SET
                " . implode(',', $properties_pairs) . "
            WHERE
                id = $id
        ";

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete() {
        global $database;
        $this->id = $database->escape_string($this->id);
        $sql = "
            DELETE FROM " . self::$db_table . " WHERE id = '$this->id' LIMIT 1
        ";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    }
}