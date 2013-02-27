
<div class="tab-content">
<div class='tab-pane active' id='lA'>
<?php    $praticien="Michel"; 
    $planning="planning1";
    include(ABSPATH."planning.php");
?>    </div>
<div class='tab-pane' id='lB'>
<?php    $praticien="Claude"; 
    $planning="planning2";
    include(ABSPATH."planning.php");
/*
$praticiens=getPraticiens($cabinet);
$i=0;
foreach($praticiens AS $pra) {
    $i++;
    echo "<div class='tab-pane active' id='l".chr(64+$i).">";
    $praticien=$pra["pra_nom"];
    $planning="planning".$i;
    include(ABSPATH."planning.php");
    echo "</div>";
}*/

$praticiens=getPraticiens($cabinet);
$i=0;
foreach($praticiens AS $pra) {
    $i++;
    echo "<li ";
        if($i==1)
            echo "class='active'";
        echo"><a href='#l".chr(64+$i)."' data-toggle='tab'>".$pra["pra_nom"]."</a>
          </li>";
}
?>    </div></div>