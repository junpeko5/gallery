<?php

class Db_object {
    protected static $db_table;
    public $tmp_path;
    public $upload_directory = "images";
    public $upload_errors_array = array(
        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in ",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
    );
    public $errors = array();


    public static function find_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table);
    }

    public static function find_by_id($id) {
        $the_result_array = static::find_by_query("
            SELECT 
                * 
            FROM 
                " . static::$db_table . " 
            WHERE 
                id = $id 
            LIMIT 1
        ");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public function set_file($file) {
//        echo '<pre>';
//        var_dump($file);
//        echo '</pre>';
//        exit;
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif ($file['error'] !== 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
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

    public function save() {

        return isset($this->id) ? $this->update() : $this->create();
    }

    public function update() {
        global $database;

        $properties = $this->clean_properties();

        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key} = {$value}";
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
        $table = static::$db_table;

        $sql = "
            DELETE FROM {$table} WHERE id = $this->id LIMIT 1
        ";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public static function count_all() {
        global $database;
        $table = static::$db_table;
        $sql = "
            SELECT
                COUNT(*)
            FROM
                {$table}
        ";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }


}