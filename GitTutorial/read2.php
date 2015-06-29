<!DOCTYPE html><html><head></head><body>   
<?php
  define('DEBUG_MODE', 0); // 1 is verbose, 0 is non-verbose for Ajax
  define('NO_OF_QUESTIONS', 5);
  define('USEFUL_STRING', 7); // usually number of  questions plus 2: one for action, one for what to display
  $myInput = htmlspecialchars($_GET["q"]);
  say ("Hi..." . $myInput, DEBUG_MODE);
  if (strlen($myInput) < USEFUL_STRING) { die ("Input string " . $myInput . " too short"); }      
  $myAction = substr($myInput, NO_OF_QUESTIONS, 1);
  $myReplyT = substr($myInput, NO_OF_QUESTIONS+1, 1);
  switch ($myAction) {
    case 0: // do nothing
        say ("do nothing", DEBUG_MODE);
        process_reply_action($myAction, $myReplyT);
        break;
    case 1: // clean
        say ("clean", DEBUG_MODE);
        xclean();
        process_reply_action($myAction, $myReplyT);
        break;
    case 2: // add
        say ("add", DEBUG_MODE);
        xadd($myInput);
        process_reply_action($myAction, $myReplyT);
        break;
    default:
        say ("wrong call", DEBUG_MODE);
        die("Bad data input for action");
  }

  function say($str, $debugLevel) {
      if ($debugLevel) {echo $str;}
  }

  function process_reply_action($inputAction, $inputReplyType) { // model after reply, uses Ajax so put reply into echo
     $outputString = ($inputReplyType == 9) ?   (file_get_contents('/home/public/script1/iter2/fullresults.txt') . PHP_EOL . PHP_EOL) : "";
     $outputString .= file_get_contents('/home/public/script1/iter2/results.txt');
     echo "<p>Results: <p/><pre>" . $outputString . "  </pre>"; // better yet, make this the return value of process_reply_action and have main() echo it
  }

  function xclean() { // mind the chmode of the text files...
    $cfile = fopen("/home/public/script1/iter2/results.txt","w") or die("Unable to open file for cleaning!");
    fwrite($cfile,"0\t0\t0\t0\t0" . PHP_EOL);
    fclose($cfile);
    $cfile = fopen("/home/public/script1/iter2/fullresults.txt","w") or die("Unable to open file for cleaning!");
    fwrite($cfile,"");
    fclose($cfile);
  }

  function xadd($myStr) { // mind the chmode of the text files...
    define('STR_DELTA', 65); // delta between number and character used to encode the reply, A being zero
    for($i = 0; $i < NO_OF_QUESTIONS; $i++) {
       $resp[$i] = ord(substr($myStr, $i, 1)) - STR_DELTA;
    }  
    $inputUserName = (strlen($myStr) > USEFUL_STRING ? substr($myStr, USEFUL_STRING) : "_anonymous");
    $cfile = fopen("/home/public/script1/iter2/results.txt","r") or die("Unable to open file for reading!");
    $oldResult = fgets($cfile);
    fclose($cfile);
    $partialResult = explode("\t", $oldResult);
    $newResult = "";
    for($i = 0; $i < NO_OF_QUESTIONS; $i++) {
       $addVal = $partialResult[$i] + $resp[$i];    // new topline result
       $newResult = $newResult . $addVal . "\t";    // build line using tabs, to be written to result
    }
    $cfile = fopen("/home/public/script1/iter2/results.txt","w") or die("Unable to open file for writing!");
    fwrite($cfile, $newResult . PHP_EOL);
    fclose($cfile); // and now open fullresults in append mode and append line
    $newLineFullResult = "";
    for ($i = 0; $i < NO_OF_QUESTIONS; $i++) {
        $newLineFullResult .= $resp[$i] . "\t";
    }
    $newLineFullResult .= $inputUserName;
    $cfile = fopen("/home/public/script1/iter2/fullresults.txt","a+") or die("Unable to open file for appending!");
    fwrite($cfile, $newLineFullResult . PHP_EOL);
    fclose($cfile);
  }         
?>
</body></html>