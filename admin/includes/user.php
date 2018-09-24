<?php

class User extends Db_object {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;


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

        $the_result_array = self::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public function save() {

        return isset($this->id) ? $this->update() : $this->create();
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
                " . static::$db_table . "
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
            DELETE FROM " . static::$db_table . " WHERE id = '$this->id' LIMIT 1
        ";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    }








}