<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of type_ope
 *
 * @author kerne
 */
class type_ope {

    //put your code here

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /*     * ******
     * verification de l'existance du Type d'operations
     */

    public function verif_type_ope($nomtype) {
        $reponse = $this->db->count("SELECT * FROM credit_types WHERE NomType =?", [$nomtype]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*     * **
     * insertion de du type d'operation
     */

    public function add_type_ope($nomtype, $descrtype, $date_ajout, $idad) {
        return $this->db->insert("INSERT INTO credit_types(idType,NomType,DescType,DateType,IdAdmin)VALUES(?,?,?,?,?)", [null, $nomtype, $descrtype, $date_ajout, $idad]);
    }

    /**
     *
     * selection des operations
     */
    public function select_type_ope() {
        $select_creance = $this->db->select("SELECT * FROM credit_types,credit_admins WHERE credit_types.IdAdmin=credit_admins.IdAdmin");
        return $select_creance;
    }

    /**
     * supprimer une operation
     */
    public function del_type_ope($idtype) {
        return $this->db->insert("DELETE FROM credit_types WHERE IdType=?", [$idtype]);
    }

    //verification du type d'operation
    public function verif_id_type_ope($id) {
        $reponse = $this->db->count("SELECT * FROM credit_types,credit_admins WHERE credit_types.IdAdmin=credit_admins.IdAdmin AND IdType=?", [$id]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*
     * selection
     */

    public function id_type_ope($id) {
        $edit_client = $this->db->select("SELECT * FROM credit_types,credit_admins WHERE credit_types.IdAdmin=credit_admins.IdAdmin AND IdType=?", [$id]);
        return $edit_client;
    }

    /*
     * verification de l'id
     */

    public function verif_id_type_op($id) {
        $reponse = $this->db->count("SELECT * FROM credit_types WHERE IdType=?", [$id]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*
     * Editer un type
     */

    public function verif_type_op($id) {
        $edit_type = $this->db->select("SELECT * FROM credit_types WHERE IdType=?", [$id]);
        return $edit_type;
    }

    /*
     * editer le type operation
     */

    public function edit_type_op($nomtype, $desctype, $id) {
        return $this->db->insert("UPDATE credit_types SET NomType=?, DescType=? WHERE IdType=?", [$nomtype, $desctype, $id]);
    }

}
