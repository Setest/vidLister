<?php
class vlVideo extends xPDOSimpleObject {

    function duration()
   	{
        $seconds_count = $this->get('duration');

        $seconds = $seconds_count % 60;
        $minutes = floor($seconds_count/60);
        $hours   = floor($seconds_count/3600);

        $seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
        $hours   = str_pad($hours,   2, "0", STR_PAD_LEFT);

        return array(
            'hh' => $hours,
            'mm' => $minutes,
            'ss' => $seconds,
            'seconds' => $seconds_count
        );
   	}

}