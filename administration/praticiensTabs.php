<?php
$praticiens=getPraticiens($cabinet);
$i=0;
foreach($praticiens AS $pra) {
    $i++;
    echo "<li ";
        if($i==1)
            echo "class='active'";
        echo"><a id='l".chr(64+$i)."_btn' href='#l".chr(64+$i)."' class='tab_pra' data-toggle='tab'>".$pra["pra_nom"]."</a>
          </li>";
}
echo "<li><a href='addpraticien.php'>Ajouter praticien</a></li>";
?>