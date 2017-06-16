<?php
    class Prints {

        /**
         * Prints the keyword "checked" if the $value equals $obj->$property
         * It's made to inputs type checkbox
         * @param  array/object $obj    Array or Object to explore property/position
         * @param  string $property     Param/position to be searched on $obj
         * @param  string $value        Value to be verified
         * @return void
         */
        public static function check($obj, $property, $value) {
            if (is_array($obj)) (object)$obj;
            echo (!empty($obj->$property) && $obj->$property == $value)? "checked": "";
        }

        /**
         * Prints the keyword "selected" if the $value equals $obj->$property
         * It's made to tag select options
         * @param  array/object $obj    Array or Object to explore property/position
         * @param  string $property     Param/position to be searched on $obj
         * @param  string $value        Value to be verified
         * @return void
         */
        public static function select($obj, $property, $value) {
            if (is_array($obj)) (object)$obj;
            echo (!empty($obj->$property) && $obj->$property == $value)? "selected": "";
        }
        
        /**
         * This function allow you modify the echo by Session::it! 
         */
        public static function itPersonal($obj, $value, $conValue ) {
            ob_start();
            self::it($obj, $value);
            $backup = ob_get_clean();
            if ( array_key_exists( $backup, $conValue) ) 
                echo $conValue[$backup];
        }
        /**
         * Prints $obj->$property value
         * @param  array/object $obj    Array or Object to explore property/position
         * @param  [string] $property   Param/position to be searched on $obj
         * @param  string $type         The type to format $obj->$property
         * @param  string $default      The default value to be print case $obj->$property is null
         * @return void
         */
        public static function it($obj, $property, $type ='', $default = '', $removes = '') {
            if (is_array($obj)) (object)$obj;
            if (!empty($obj->$property)) {
                $backup = $obj->$property;
                self::switchType($type, $obj, $property);
                echo str_replace($removes, '', $obj->$property);
                $obj->$property = $backup;
            } else {
                echo $default;
            }
        }

        /**
         * Auxiliar function to switch format types
         * @param  string $type     type to format $obj->$property value
         * @param  object $obj      the object to explore property
         * @param  string $property property to be searched on $obj
         * @return void
         */
        private static function switchType($type = '', &$obj, $property) {
            if (!empty($type) && !empty($obj->$property)) {
                $exp = explode('/', $type);
                $func = 'a'.ucfirst($exp[0]);
                $obj->$property = self::$func($obj->$property, $exp[1]);
            }
        }

        /**
         * Formats $obj->$property to GET URL
         * @param  string $value    The value to the GET property
         * @param  string $property The GET property
         * @return string           Ther formatted string
         */
        private static function aGet($value, $property) {
            $property = strtolower($property);
            return (!empty($value))? "?{$property}={$value}": '';
        }

        /**
         * Formats dates
         * @param  string $notStoned The unformatted date
         * @param  string $language  The language that the date will be formatted
         * @return string            The formatted date
         */
        public static function aDate($notStoned, $language) {
            $language = strtolower($language);
            $date = date_create_from_format('Y-m-d', $notStoned);
            switch ($language) {
                case 'br':
                    return date($date->format('d/m/Y'));
                    break;

                default:
                    return $date;
                    break;
            }
        }

    }
