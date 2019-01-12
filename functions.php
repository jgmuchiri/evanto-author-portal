<?php
if(!function_exists('dd')) {
    /**
     * Dumps a given variable along with some additional data.
     *
     * @param mixed $var
     * @param bool  $pretty
     */
    function dd($var, $pretty = TRUE)
    {
        $backtrace = debug_backtrace();
        echo "\n<pre>\n";
        if(isset($backtrace[0]['file'])) {
            echo $backtrace[0]['file']."\n";
            echo "Line:".$backtrace[0]['line']."\n\n";
        }
        echo "Type: ".gettype($var)."\n";
        echo "Time: ".date('c')."\n";
        echo "---------------------------------\n\n";
        ($pretty) ? print_r($var) : var_dump($var);
        echo "</pre>\n";
        die;
    }
}
?>