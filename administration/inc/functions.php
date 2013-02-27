<?php
function checkUsers($login, $pwd)
{

	$res = mysql_query("
		SELECT
			role
		FROM
			user
		WHERE
			login='".$login."'
		AND
			password='".$pwd."'
	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr;
}

function deleteUser($person_id)
{

	$res = mysql_query("
		DELETE FROM
			tbl_users
		WHERE
			person_id = '".$person_id."';
	")or die(mysql_error());

}

function deletePosition($person_id)
{

	$res = mysql_query("
		DELETE FROM
			tbl_positions
		WHERE
			person_id = '".$person_id."';
	")or die(mysql_error());

}

function editUser($id, $email, $pseudo, $firstname, $lastname, $postalcode, $city)
{
	//global $database_name;
	
		$data_res = mysql_query("
			UPDATE
				tbl_users
			SET
				email = '".$email."',
				pseudo = '".$pseudo."',
				firstname = '".$firstname."',
				lastname = '".$lastname."',
				postalcode = '".$postalcode."',
				city = '".$city."'
			WHERE
				id = '".$id."'
		")or die(mysql_error());
}

function getUserCabinet($login, $pwd)
{
    $res = mysql_query("
		SELECT
                    *
                FROM
                    Cabinet
                WHERE
                    cab_loginSec='".$login."'
                AND cab_mdpSec='".$pwd."'
	")or die(mysql_error());
    
    while ($row = mysql_fetch_array($res))
    {
            $arr[] = $row;
    }

    if(isset($arr))
        return $arr;
    else {
        $num = mysql_num_rows($res);
        return $num;
    }
}

function isLeapYear($year) // est une annŽe bissextile
{
  return (cal_days_in_month(CAL_GREGORIAN, 2, $year) === 29) ? true : false;
}

function generateEachDay($year,$month,$dayMax,$table) {
    for($day=1; $day<=$dayMax; $day++) {
        $date=$year."-".$month."-".$day;
        $date=date("Y-m-d", strtotime($date));
        insertDate($date);
        
    }
}

function insertDate($date) {
    $data_res = mysql_query("
            INSERT INTO
                    Date
            VALUES
            (
                '".$date."'
            )
    ")or die(mysql_error());
}

function insertCrenau($date, $hour, $praticien) {
    $data_res = mysql_query("
            INSERT INTO
                    Crenaux
            (
                cre_id,
                cre_disponibilite,
                cli_id,
                heu_heures,
                dat_date,
                pra_id
            
            )
            VALUES
            (
                '',
                '0',
                '".NULL."',
                '".$hour."',
                '".$date."',
                '".$praticien."'
            )
    ")or die(mysql_error());
}

function dateExist($date)
{
    $res = mysql_query("
		SELECT
                    *
                FROM
                    Date
                WHERE
                    dat_date='".$date."'

	")or die(mysql_error());
    
    $num = mysql_num_rows($res);

    return $num;
}

function getPraticiens($cabinet) {

    $res = mysql_query("
                SELECT
                        pra_id,
                        pra_nom
                FROM
                        Praticien
                INNER JOIN Cabinet ON Praticien.cab_id = Cabinet.cab_id
                WHERE
                        Praticien.cab_id='".$cabinet."'
                ORDER BY
                        pra_nom ASC
        ")or die(mysql_error());
    
        while ($row = mysql_fetch_array($res))
        {
                $arr[] = $row;
        }
    
        return $arr;
}

function getClients() {

    $res = mysql_query("
                SELECT
			*
                FROM
                        Client
                ORDER BY
                        cli_nom ASC
        ")or die(mysql_error());
    
        while ($row = mysql_fetch_array($res))
        {
                $arr[] = $row;
        }
    
        return $arr;
}

function getCrenaux($praticien, $dateBegin, $dateEnd)
{

	$res = mysql_query("
            SELECT
                    cre_id,
                    cli_nom,
                    heu_heures,
                    Crenaux.dat_date,
                    pra_nom,
                    cre_disponibilite
            FROM
                (
                    SELECT
                            dat_date
                    FROM
                            Crenaux
                    WHERE
                            dat_date
                    BETWEEN '".$dateBegin."' AND '".$dateEnd."'
                    GROUP BY dat_date ASC
                    LIMIT 7
                ) date
                JOIN Crenaux ON date.dat_date=Crenaux.dat_date
                LEFT JOIN Client ON Client.cli_id = Crenaux.cli_id
                INNER JOIN Praticien ON Praticien.pra_id = Crenaux.pra_id
                WHERE pra_nom='".$praticien."' 
                ORDER BY heu_heures,Crenaux.dat_date ASC	
	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr;
}

function get31LastDates()
{

	$res = mysql_query("
		SELECT
			dat_date
		FROM
                        Date
                ORDER BY
                        dat_date
                DESC
                LIMIT 31
	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr;
}

function getHours()
{

	$res = mysql_query("
		SELECT
			heu_heures
		FROM
                        Heure
	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr;
}

function countPraticiens($cabinet)
{
    $res = mysql_query("
		SELECT
                    pra_id
                FROM
                    Praticien
                WHERE
                    cab_id='".$cabinet."'

	")or die(mysql_error());
    
    $num = mysql_num_rows($res);

    return $num;
}

function generatePlanningCells ($crenaux, $praticien) {
    $hour=NULL;
    $indexCell=0;
    $createPause=NULL;
    
    foreach($crenaux AS $crenau) {
        $indexCell++;
            if($crenau["heu_heures"]==date("H:i:s", strtotime('14:30:00')) && !isset($createPause)) { // creer la colone de pause entre midi et deux
                echo"<tr><th colspan=7 style='text-align:center'>PAUSE</th></tr>";
                $createPause=1;
            }
            if($crenau["heu_heures"]!=$hour OR !isset($hour)) {
                echo "<tr>
                        <th>".date("G:i", strtotime($crenau["heu_heures"]))."</th>";
            }

            if(date("N", strtotime($crenau["dat_date"])) != 7)  //si le crenau n'est pas un dimanche
                echo"<td id='".$crenau['cre_id']."' onclick='getCrenauId(this)'>".$crenau["cli_nom"]."</td>";

            if($indexCell==7) {
                echo "</tr>";
                $indexCell=0;
            }
        $hour=$crenau["heu_heures"];
    }
}

function issetAndNotEmpty($var) {
    if(isset($var) && !empty($var))
        return TRUE;
    
    return FALSE;
}

function clientExist($lastName, $firstName, $postalCode)
{
    $res = mysql_query("
		SELECT
                    cli_id
                FROM
                    Client
                WHERE
                    cli_nom='".$lastName."'
                AND
                    cli_prenom='".$firstName."'
                AND
                    cli_cp='".$postalCode."'

	")or die(mysql_error());
    
    while ($row = mysql_fetch_array($res))
    {
            $arr[] = $row;
    }

    if(isset($arr))
        return $arr;
    else {
        $num = mysql_num_rows($res);
        return $num;
    }
}

function getCrenauById($id)
{

	$res = mysql_query("
		SELECT
			cli_nom, cli_prenom, pra_nom, dat_date, heu_heures
		FROM
                        Crenaux
		LEFT JOIN
			Client
		ON
			Client.cli_id = Crenaux.cli_id
		LEFT JOIN
			Praticien
		ON
			Praticien.pra_id = Crenaux.pra_id
		WHERE
			Crenaux.cre_id = '".$id."'
	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr[0];
}

function editCrenau($cli_id, $id)
{
	//global $database_name;
	
		$data_res = mysql_query("
			UPDATE
				Crenaux
			SET
				cre_disponibilite = '1',
				cli_id = '".$cli_id."'
			WHERE
				cre_id = $id
		")or die(mysql_error());
}

function insertClient($lastName, $firstName, $postalCode) {
    $data_res = mysql_query("
            INSERT INTO
                    Client
            (
                cli_id,
                cli_nom,
                cli_prenom,
                cli_cp            
            )
            VALUES
            (
                '',
                '".$lastName."',
                '".$firstName."',
                '".$postalCode."'
            )
    ")or die(mysql_error());
}

function createTabsPraticiens($cabinet) {
    $praticiens=getPraticiens($cabinet);
    $i=0;
    foreach($praticiens AS $pra) {
        $i++;
        echo "<div class='tab-pane active' id='l".chr(64+$i).">";
        $praticien=$pra["pra_nom"];
        $planning="planning".$i;
        include(ABSPATH."planning.php");
        echo "</div>";
    }
}

function getCabinets()
{

	$res = mysql_query("
		SELECT
			cab_id
		FROM
                        Cabinet
	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr;
}

function getDatesFromNow()
{

	$res = mysql_query("
                SELECT
                        dat_date
                FROM
                        Date
                WHERE
                        dat_date >= CURRENT_DATE()
                ORDER BY
                        dat_date DESC

	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr;
}

function browseDateAndHourAndInsertCrenau($dates,$praticien) {
    $hours=getHours();
    foreach($dates as $date) {
        foreach($hours as $hour) {
            insertCrenau($date["dat_date"], $hour["heu_heures"], $praticien);
        }
    }
}

function insertPraticien ($nom) {
    $data_res = mysql_query("
            INSERT INTO
                    Praticien
            (
                pra_id,
                pra_nom,
                pra_prenom,
                pra_grade,
                pra_mdp,
                civ_id,
                cab_id
            
            )
            VALUES
            (
                '',
                '".$nom."',
                '',
                '',
                '',
                '5',
                '5'
            )
    ")or die(mysql_error());
}

function getLastAddedPraticien() {
        $res = mysql_query("
                SELECT
                        pra_id
                FROM
                        Praticien
                ORDER BY
                        pra_id
                DESC
                LIMIT 1

	")or die(mysql_error());

	while ($row = mysql_fetch_array($res))
	{
		$arr[] = $row;
	}

	return $arr[0]; // return unique praticien
}
?>