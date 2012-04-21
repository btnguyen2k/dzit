<?php
class Quack_Util_IdUtils {

    const MASK_TIMESTAMP_64 = 0x1FFFFFFFFFF; // 41 bits
    const MASK_NODE_ID_64 = 0x3FF; // 10 bits
    const MASK_SEQUENCE_64 = 0x1FFF; // 13 bits
    const SHIFT_TIMESTAMP_64 = 23;
    const SHIFT_NODE_ID_64 = 13;
    const TIMESTAMP_EPOCH = 1335632400; // 29-Apr-2012

    const MASK_NODE_ID_128 = 0xFFFFFFFFFFFF; // 48 bits
    const MASK_SEQUENCE_128 = 0xFFFF; // 16 bits
    const SHIFT_TIMESTAMP_128 = 64;
    const SHIFT_NODE_ID_128 = 16;

    /**
     * Generates a 64-bit id as a binary string (no padding).
     *
     * @param string $nodeId
     */
    public static function id64bin($nodeId = 1) {
        list($usec, $sec) = explode(" ", microtime());
        $usec = $usec * 1000000;

        $sequence = (int)($usec) & self::MASK_SEQUENCE_64;
        $nodeId = $nodeId & self::MASK_NODE_ID_64;
        $timestamp = ($sec - self::TIMESTAMP_EPOCH) & self::MASK_TIMESTAMP_64;

        $timestampBin = decbin($timestamp);
        $nodeIdBin = decbin($nodeId);
        $sequenceBin = decbin($sequence);

        while (strlen($nodeIdBin) < 10) {
            $nodeIdBin = "0$nodeIdBin";
        }
        while (strlen($sequenceBin) < 13) {
            $sequenceBin = "0$sequenceBin";
        }

        return $timestampBin . $nodeIdBin . $sequenceBin;
    }

    /**
     * Generates a 64-bit id as a hexadeximal string (with padding).
     *
     * @param string $nodeId
     */
    public static function id64hex($nodeId = 1) {
        $resultBin = self::id64bin($nodeId);
        while (strlen($resultBin) < 64) {
            $resultBin = "0$resultBin";
        }

        $tokens = str_split($resultBin, 8);
        $resultHex = '';
        foreach ($tokens as $token) {
            $temp = dechex(bindec($token));
            if (strlen($temp) < 2) {
                $temp = "0$temp";
            }
            $resultHex .= $temp;
        }
        return $resultHex;
    }

    // /**
    // * Generates a 64-bit id.
    // *
    // * @param int $nodeId
    // */
    // public static function id64($nodeId = 1) {
    // $timestamp = time();
    // $sequence = $timestamp & self::MASK_SEQUENCE_128;
    // $nodeId = $nodeId & self::MASK_NODE_ID_64;
    // var_dump($timestamp);
    // var_dump($nodeId);
    // var_dump($sequence);

    // $timestamp = ($timestamp - self::TIMESTAMP_EPOCH) &
    // self::MASK_TIMESTAMP_64;
    // return ($timestamp << self::SHIFT_TIMESTAMP_64) | ($nodeId <<
    // self::MASK_NODE_ID_64) | ($sequence);
    // }
}

echo Quack_Util_IdUtils::id64hex(1), "\n";
usleep(1);
echo Quack_Util_IdUtils::id64hex(2), "\n";
usleep(1);
echo Quack_Util_IdUtils::id64hex(3), "\n";
