<?php
$crenaux = getCrenaux($praticien, date("Y-m-d", $dateBeginWeek), date("Y-m-d", $dateEndWeek));
$days=array(
                array("Lundi", "Monday"),
                array("Mardi", "Tuesday"),
                array("Mercredi", "Wednesday"),
                array("Jeudi", "Thursday"),
                array("Vendredi", "Friday"),
                array("Samedi", "Saturday")
);
?>
<table class="table table-bordered planning" id="<?php echo $planning; ?>">
    <thead>
        <tr>
            <th></th>
<?php
foreach($days as $day) {
    echo "<th class='fix-cell' style='width:175px;'>
            <div style='float:left;width:50%;'>".$day[0]."</div>
            <div style='float:right;width:50%;text-align:left;'>".date('d/m', strtotime($day[1].' this week', $dateBeginWeek))."</div>
          </th>";
}
?>
                </tr>
    </thead>
    <tbody>
<?php
generatePlanningCells($crenaux, $praticien);
?>
    </tbody>
</table>