<a href="/server.php">look server.php</a>
<?php
preg_match('/(multipart\/[\w-]+); boundary\=(\S+)/', 'multipart/form-data; boundary=----WebKitFormBoundarySH5feRamCGo2Yd8Z', $match);
print_r($match);
?>
