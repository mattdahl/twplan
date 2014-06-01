<?php

class AppExceptionHandler {
    public static function handle ($error) {
    	CakeLog::write('error', $error);

    	# May work on production, but debugging is annoying
    	#if ($error instanceof MissingViewException || $error instanceof MissingControllerException) {
    	#      header('Location: /index');
    	#      exit;
    	#}
    }
}

?>