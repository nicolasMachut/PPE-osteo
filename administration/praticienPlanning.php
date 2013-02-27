
<div class="tab-content">
<?php
    $praticiens=getPraticiens($cabinet);
    $i=0;
    foreach($praticiens AS $pra) {
        $i++;
        echo "<div class='tab-pane";
        if($i==1) // pour n'afficher qu'un seul planning
            echo" active";
        echo "' id='l".chr(64+$i)."'>";
        $praticien=$pra["pra_nom"];
        $planning="planning".$i;
        include(ABSPATH."planning.php");
        echo "</div>";
    }
?>
</div>