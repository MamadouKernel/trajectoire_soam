<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creancier
 *
 * @author kerne
 */
class creancier {

    //put your code here

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /*     * ******
     * verification de l'existance de l'admin
     */

    public function verif_creancier($email, $nump) {
        $reponse = $this->db->count("SELECT * FROM credit_clients WHERE EmailClient =? && IdentiteClient=?", [$email, $nump]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*     * **
     * insertion de l'admin
     */

    public function add_creancier($image, $np, $tel, $email, $resid, $prof, $revm, $typepie, $nump, $rect, $verso, $date_ajout, $idad) {
        return $this->db->insert("INSERT INTO credit_clients VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [NULL, $image, $np, $tel, $email, $resid, $prof, $revm, $typepie, $nump, $rect, $verso, $date_ajout, $idad]);
    }

    /**
     *
     * selection des creanciers
     */
    public function select_creancier() {
        $select_creance = $this->db->select("SELECT * FROM credit_clients,credit_admins WHERE credit_clients.IdAdmin=credit_admins.IdAdmin");
        return $select_creance;
    }

    /**
     * supprimer un administrateur ou gestionnaire
     */
    public function del_creancier($idcrea) {
        return $this->db->insert("DELETE FROM credit_clients WHERE IdClient=?", [$idcrea]);
    }

    //verification du creancier
    public function verif_id_creancier($id) {
        $reponse = $this->db->count("SELECT * FROM credit_clients,credit_admins WHERE credit_clients.IdAdmin=credit_admins.IdAdmin AND IdClient=?", [$id]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*
     * Editer un profile
     */

    public function id_creancier($id) {
        $edit_client = $this->db->select("SELECT * FROM credit_clients,credit_admins WHERE credit_clients.IdAdmin=credit_admins.IdAdmin AND IdClient=?", [$id]);
        return $edit_client;
    }

    /*
     * editer le creancier
     */

    public function edit_creancier($image, $np, $phone, $email, $resid, $profe, $revm, $typepie, $nump, $recto, $verso, $id) {
        return $this->db->insert("UPDATE credit_clients SET PhotoClient=?, NomprenomsClient=?,PhoneClient=?,EmailClient=?,ResidenceClient=?,ProfessionClient=?,RevenumoyenClient=?,TypepieceClient=?,IdentiteClient=?,RectopieceClient=?,VersopieceClient=? WHERE IdClient=?", [$image, $np, $phone, $email, $resid, $profe, $revm, $typepie, $nump, $recto, $verso, $id]);
    }

}
