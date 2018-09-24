<?php

class Db_object {
    protected static $db_table = "users";


    public static function find_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table);
    }

    public static function find_by_id($user_id) {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $user_id LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }

    public static function instantiation($the_record) {
        $calling_call = get_called_class();

        $the_object = new $calling_call();

        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    public function has_the_attribute($the_attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }


    protected function properties() {

//        return get_object_vars($this);
        $properties = array();
        foreach (static::$db_table_fields as $db_field) {
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
            if (!empty($value)) {
                $clean_properties[$key] = $database->escape_string($value);
                if (is_string($value)) {
                    $clean_properties[$key] = "'" . $clean_properties[$key] . "'";
                }
            }
        }
        return $clean_properties;
    }



    
    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "
            INSERT INTO
                " . static::$db_table . "
                (" . implode(",", array_keys($properties)) . ")
            VALUES
                (" . implode(",", array_values($properties)) . ")
        ";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }


}