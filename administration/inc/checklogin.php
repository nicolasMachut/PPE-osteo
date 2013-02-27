<?php
if(!isset($_SESSION["cab"])) {
header("location: index.php?err=1");
}
?>