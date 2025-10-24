<?php

if (!function_exists('hex2rgba')) {
    /**
     * تحويل لون الخلفية إلى صيغة rgba لتطبيق الشفافية
     *
     * @param string $color
     * @param float $opacity
     * @return string
     */
    function hex2rgba($color, $opacity)
    {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        if (strlen($color) == 6) {
            list($r, $g, $b) = array(
                hexdec(substr($color, 0, 2)),
                hexdec(substr($color, 2, 2)),
                hexdec(substr($color, 4, 2))
            );
            return "rgba($r, $g, $b, $opacity)";
        }
        return $color;
    }
} 