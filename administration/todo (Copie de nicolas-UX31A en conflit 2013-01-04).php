TODO :
- finir formulaire (modif get ou post ?) ======> FAIT
- traiter donner formulaire =====> FAIT
- affichage planning par mois/jour/semaine
- liste jour feriŽs
- bulle info rdv client
- generer planning (copier heure date dans crenaux http://sqlpro.developpez.com/cours/sqlaz/dml/#LII-E) (NB : verifier si ca a marchŽ au 1er Janvier 2013)
    --> resoudre id planning (essayer avec une classe) =======> FAIT
- modif style de "PAUSE" dans planning, go to the osteo css !
- date dans planning
- commenter fonctions + mettre de l'odre
- completer formulaire
- Praticienplanning, acceuil nav tab a propriser !

NB : 16 rdv par jour, 6jours de taff / semaine


RDV PAR JOUR
SELECT
			cli_nom,
                        heu_heures,
                        Crenaux.dat_date,
                        pra_nom,
                        cre_disponibilite
		FROM
            
                Crenaux
                LEFT JOIN Client ON Client.cli_id = Crenaux.cli_id
                INNER JOIN Praticien ON Praticien.pra_id = Crenaux.pra_id
                WHERE pra_nom="Claude" 
                ORDER BY dat_date ,heu_heures ASC
                LIMIT 16
                
gerer ecart planning jour
$jour=date("N", strtotime($crenau["dat_date"]));
while($indexCell!=$jour) {
    echo "<td>test".$indexCell."</td>";
    $indexCell++;
}