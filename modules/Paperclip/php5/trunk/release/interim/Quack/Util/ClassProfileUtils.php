<?php
class Quack_Util_ProfileUtils {

    const KEY_CHILDREN = 'CHILDREN';
    const KEY_PARENT = 'PARENT';
    const KEY_NAME = 'NAME';
    const KEY_TIMESTAMP_START = 'TIMESTAMP_START';
    const KEY_TIMESTAMP_END = 'TIMESTAMP_END';
    const KEY_DURATION = 'DURATION';

    private static $root = Array();
    private static $logEntry = NULL;
    private static $profiling = Array(self::KEY_PARENT => NULL,
            self::KEY_CHILDREN => Array(),
            self::KEY_NAME => '');
    private static $current = NULL;

    private static function &locateNode($path) {
        if ($path === NULL) {
            return NULL;
        }
        $tokens = explode('|', $path);
        $temp = &self::$profiling;
        foreach ($tokens as $token) {
            $temp = &$temp[self::KEY_CHILDREN][$token];
        }
        return $temp;
    }

    /**
     * "Pushes" a profiling data to the stack.
     *
     * @param string $name
     */
    public static function push($name) {
        // create a new entry
        $entry = Array(self::KEY_CHILDREN => Array(),
                self::KEY_NAME => $name,
                self::KEY_PARENT => self::$current,
                self::KEY_TIMESTAMP_START => microtime());
        if (self::$current !== NULL) {
            $current = &self::locateNode(self::$current);
            $children = &$current[self::KEY_CHILDREN];
            $children[] = &$entry;
            self::$current = self::$current . '|' . (count($children) - 1);
        } else {
            self::$profiling[self::KEY_CHILDREN][] = &$entry;
            self::$current = count(self::$profiling[self::KEY_CHILDREN]) - 1;
        }
    }

    private static function debug() {
        $temp = self::$profiling;
        print_r($temp);
    }

    /**
     * "Pops" the last profiling data from the stack
     */
    public static function pop() {
        if (self::$current === NULL) {
            throw new Exception('Illegal state!');
        }
        $current = &self::locateNode(self::$current);
        $current[self::KEY_TIMESTAMP_END] = microtime();
        self::$current = $current[self::KEY_PARENT];
    }

    /**
     * Gets tge profile log entry.
     *
     * @return Array
     */
    public static function get() {
        $result = Array();
        foreach (self::$profiling[self::KEY_CHILDREN] as $child) {
            $result[] = self::prepareProfileResult($child);
        }
        return $result;
    }

    private static function prepareProfileResult($result) {
        unset($result[self::KEY_PARENT]);
        $timeStart = $result[self::KEY_TIMESTAMP_START];
        if (!isset($result[self::KEY_TIMESTAMP_END])) {
            $result[self::KEY_TIMESTAMP_END] = microtime();
        }
        $timeEnd = $result[self::KEY_TIMESTAMP_END];

        unset($result[self::KEY_TIMESTAMP_END]);
        unset($result[self::KEY_TIMESTAMP_START]);

        list($usecStart, $secStart) = explode(" ", $timeStart);
        list($usecEnd, $secEnd) = explode(" ", $timeEnd);
        $duration = ($secEnd + $usecEnd) - ($secStart + $usecStart);
        $result[self::KEY_DURATION] = round($duration, 4);

        $children = Array();
        foreach ($result[self::KEY_CHILDREN] as $child) {
            $children[] = self::prepareProfileResult($child);
        }
        $result[self::KEY_CHILDREN] = $children;

        return $result;
    }
}
