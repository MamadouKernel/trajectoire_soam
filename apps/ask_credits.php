<?php

class ask_credits {

//put your code here

    private $db;

    public function __construct($db) {
        $this->db = $db;    
    }

    /*     * ******
     * verification du credit en cours
     */

    public function verif_ask_encour($idclient) {
        $reponse = $this->db->count("SELECT * FROM credit_emprunts WHERE IdClient =? && StatusEmprunt=1", [$idclient]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*     * **
     * insertion de l'ask_credit
     */

    public function add_ask($montant,$dateget,$dategive,$status,$date_j,$idtype,$idclient,$idadmin) {
        return $this->db->insert("INSERT INTO credit_emprunts(IdEmprunt,MontantEmprunt,DategetEmprunt,DategiveEmprunt,StatusEmprunt,DateEmprunt,Idtype,IdClient,IdAdmin)VALUES(?,?,?,?,?,?,?,?,?)", [null,$montant,$dateget,$dategive,$status,$date_j,$idtype,$idclient,$idadmin]);
    }

    /*
    *afficharge de tout les donnees de la table ask
    */

    public function select_ask(){
        $select_ask = $this->db->select("SELECT * FROM credit_emprunts,credit_admins,credit_clients,credit_types WHERE credit_emprunts.IdType=credit_types.IdType && credit_emprunts.IdClient=credit_clients.IdClient && credit_emprunts.IdAdmin=credit_admins.IdAdmin");
        return $select_ask;
    }
    /*
    *afficharge de tout les donnees de la table ask
    */

    public function select_ask_by_id($idclient){
        $select_ask = $this->db->select("SELECT * FROM credit_emprunts,credit_admins,credit_clients,credit_types WHERE credit_emprunts.IdType=credit_types.IdType && credit_emprunts.IdClient=credit_clients.IdClient && credit_emprunts.IdAdmin=credit_admins.IdAdmin && credit_emprunts.IdEmprunt=?",[$idclient]);
        return $select_ask;
    }

    /**
     * supprimer un emprunt
     */
    public function del_ask($idcrea) {
        return $this->db->insert("DELETE FROM credit_emprunts WHERE IdEmprunt=?", [$idcrea]);
    }

    /*
    * enregistrement du repayment
    */
    public function repayment($montant,$montant_rest,$status,$date_j,$idemp,$idtype,$idclient,$idadmin){
        return $this->db->insert("INSERT INTO credit_rembourssements(IdRembours,MontantRembours,MontantRestant,StatusRembours,DateRembours,IdEmprunt,IdType,IdClient,IdAdmin)VALUES(?,?,?,?,?,?,?,?,?)",[null,$montant,$montant_rest,$status,$date_j,$idemp,$idtype,$idclient,$idadmin]);
    }

    /*
     * verification de l'id
     */

    public function verif_id_emprunt($id) {
        $select_ask = $this->db->select("SELECT * FROM credit_rembourssements,credit_emprunts,credit_admins,credit_clients,credit_types WHERE credit_rembourssements.IdEmprunt=credit_emprunts.IdEmprunt && credit_rembourssements.IdType=credit_types.IdType && credit_rembourssements.IdClient=credit_clients.IdClient && credit_rembourssements.IdAdmin=credit_admins.IdAdmin && credit_rembourssements.IdEmprunt=?",[$id]);
        return $select_ask;
    }

    /**
     *verification du payement restant
     */

    public function verif_payment_rest($idclient){
        $select_pay_res = $this->db->count("SELECT * FROM `credit_rembourssements` WHERE  IdClient = ?",[$idclient]);
        return $select_pay_res;
    }

    /**
     * selection du remboursemment
     */

    public function all_repayment($idclient){
        $select_all_pay = $this->db->select("SELECT * FROM credit_rembourssements,credit_emprunts,credit_admins,credit_clients,credit_types  WHERE credit_rembourssements.IdType=credit_types.IdType && credit_rembourssements.IdClient=credit_clients.IdClient && credit_rembourssements.IdAdmin=credit_admins.IdAdmin && credit_rembourssements.IdEmprunt=credit_emprunts.IdEmprunt && IdRembours=(SELECT MAX(IdRembours) FROM credit_rembourssements) && credit_rembourssements.IdClient=?",[$idclient]);
        return $select_all_pay;
    }

    /**
     * SELECTION DE L'EMPRUNT
     */

    public function select_emprunt_by_id($id){
        $select_ask = $this->db->select("SELECT * FROM credit_emprunts,credit_admins,credit_clients,credit_types WHERE credit_emprunts.IdType=credit_types.IdType && credit_emprunts.IdClient=credit_clients.IdClient && credit_emprunts.IdAdmin=credit_admins.IdAdmin && credit_emprunts.IdEmprunt=?",[$id]);
        return $select_ask;
    }

    /**
     * SELECTION Du montant restant by id emprunt
     */

    public function select_montrest_by_emprunt($id){
        $select_ask = $this->db->select("SELECT * FROM credit_rembourssements  WHERE IdRembours=(SELECT MAX(IdRembours) FROM credit_rembourssements WHERE IdEmprunt=?)",[$id]);
        return $select_ask;
    }

    
    /**
     * selection du remboursemment
     */

    public function all_repaymentt($idemprunt){
        $select_all_pay = $this->db->select("SELECT * FROM credit_rembourssements  WHERE IdRembours=(SELECT MAX(IdRembours) FROM credit_rembourssements) && credit_rembourssements.IdEmprunt=?",[$idemprunt]);
        return $select_all_pay;
    }

    /*
    * faire la somme du rembourssement par emprunt
    */
    public function sum_remb_by_emp($idemprunt){
        $select_all_pay = $this->db->select("SELECT SUM(MontantRembours) AS MontantTRemb FROM credit_rembourssements WHERE IdEmprunt =?",[$idemprunt]);
        return $select_all_pay;
    }
    
    /*
    * update de statut dans emprunt
    */
    public function update_statut_by_emprunt($idemprunt){
        $select_all_pay = $this->db->select("UPDATE credit_emprunts SET StatusEmprunt = 0  WHERE IdEmprunt =?",[$idemprunt]);
        return $select_all_pay;
    }

    /*
    * liste des credits d'un client
    */
    public function list_emprunt_by_client($idclient){
        $select_all_emprunt = $this->db->select("SELECT * FROM credit_emprunts,credit_clients,credit_types WHERE credit_emprunts.IdClient=credit_clients.IdClient && credit_emprunts.IdType=credit_types.IdType && credit_emprunts.IdClient=?",[$idclient]);
        return $select_all_emprunt;
    }

    public function verif_id_client($id) {
        $select_ask = $this->db->select("SELECT * FROM credit_rembourssements,credit_emprunts,credit_admins,credit_clients,credit_types WHERE credit_rembourssements.IdEmprunt=credit_emprunts.IdEmprunt && credit_rembourssements.IdType=credit_types.IdType && credit_rembourssements.IdClient=credit_clients.IdClient && credit_rembourssements.IdAdmin=credit_admins.IdAdmin && credit_clients.IdClient=?",[$id]);
        return $select_ask;
    }

    /*
    * VERIFICATION DU REMBOURSSEMENT
    */

    public function verif_rembou($idemprunt) {
        $reponse = $this->db->count("SELECT * FROM credit_rembourssements WHERE IdEmprunt =? ", [$idemprunt]);
        if ($reponse) {
            return $reponse;
        }
    }

}