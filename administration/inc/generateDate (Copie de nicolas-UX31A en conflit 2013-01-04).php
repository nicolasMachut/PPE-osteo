<?php
if (date("d")==1 && !dateExist(date('Y-m-d', strtotime('+1 year')))) { //Si nous sommes le 1 du mois et que l'algo n'a pas encore ete execute
    $month=date("m");
    $year=date("Y")+1;
    
    if($month==1 OR $month==3 OR $month==5 OR $month==7 OR $month==8 OR $month==10 OR $month==12) {
        generateEachDay($year,$month,31);
    }
    elseif($month==4 OR $month==6 OR $month==9 OR $month==11) {
        generateEachDay($year,$month,30,"date");
    }
    elseif($month==2 AND isLeapYear($year)){
        generateEachDay($year,$month,29,"date");
    }
    else {
        generateEachDay($year,$month,28,"date");
    }
    
    $dates=get31LastDates();
    $hours=getHours();
    
    
    for($praticien=1; $praticien<=countPraticiens(); $praticien++) {
        foreach($dates as $date) {
            foreach($hours as $hour) {
                insertCrenau($date["dat_date"], $hour["heu_heures"], $praticien);
            }
        }
    }
}
?>