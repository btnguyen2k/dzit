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
     * Generates a 64-bit id as a binary string.
     *
     * @param string $nodeId
     * @param int $padding
     */
    public static function id64bin($nodeId = 1, $padding = 0) {
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

        $result = $timestampBin . $nodeIdBin . $sequenceBin;
        while (strlen($result) < $padding) {
            $result = "0$result";
        }
        return $result;
    }

    /**
     * Generates a 64-bit id as a hexadeximal string.
     *
     * @param string $nodeId
     * @param int $padding
     */
    public static function id64hex($nodeId = 1, $padding = 0) {
        $resultBin = self::id64bin($nodeId, 64);
        $tokens = str_split($resultBin, 8);
        $resultHex = '';
        foreach ($tokens as $token) {
            $temp = dechex(bindec($token));
            if (strlen($temp) < 2) {
                $temp = "0$temp";
            }
            $resultHex .= $temp;
        }
        while (strlen($resultHex) < $padding) {
            $resultHex = "0$resultHex";
        }
        return $resultHex;
    }
}
