<?php

class AppExceptionHandler {
    public static function handle($error) {
    	CakeLog::write('error', $error);
    }
}

?>