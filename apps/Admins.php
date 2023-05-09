<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admins
 *
 * @author kerne
 */

class Admins {

    //put your code here

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /*     * ******
     * verification de l'existance de l'admin
     */

    public function verif_admin($email, $nump) {
        $reponse = $this->db->count("SELECT * FROM credit_admins WHERE EmailAdmin =? && NumpieceAdmin=?", [$email, $nump]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*     * **
     * insertion de l'admin
     */

    public function add_admin($image, $np, $email, $tel, $mdp, $role, $typepie, $nump, $date_ajout) {
        return $this->db->insert("INSERT INTO credit_admins(idAdmin,image,NomprenomsAdmin,EmailAdmin,PhoneAdmin,PasswordAdmin,LevelAdmin,TypepieceAdmin,NumpieceAdmin,DateAdmin)VALUES(?,?,?,?,?,?,?,?,?,?)", [null, $image, $np, $email, $tel, $mdp, $role, $typepie, $nump, $date_ajout]);
    }

    /*     * ***
     * connexion de l'administrateur
     */

    public function _login_admin($email, $password, $role) {
        $admin = $this->db->Show("SELECT * FROM credit_admins WHERE  EmailAdmin=:login  && passwordAdmin=:pass && LevelAdmin=:level", [
            'login' => $email,
            'pass' => $password,
            'level' => $role
        ]);

        if ($admin) {
            $_SESSION['admin']['id'] = $admin[0]->IdAdmin;
            $_SESSION['admin']['nomprenom'] = $admin[0]->NomprenomsAdmin;
            $_SESSION['admin']['role'] = $admin[0]->LevelAdmin;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * selection de l'id connectee
     */
    public static function admin_id() {
        return $_SESSION['admin']['id'];
    }

    /*
     * selectionne l'utilisateur
     */

    public function _log_connect() {
        return $this->db->Show("SELECT * FROM credit_admins WHERE   IdAdmin =" . self::admin_id());
    }

    /*     * **
     * selectionne tout les enregistrements de la table admin
     */

    public function select_admin() {
        $select_admin = $this->db->select("SELECT * FROM credit_admins");
        return $select_admin;
    }

    /**
     * supprimer un administrateur ou gestionnaire
     */
    public function del_admin($idadmin) {
        return $this->db->insert("DELETE FROM credit_admins WHERE IdAdmin=?", [$idadmin]);
    }

    /*
     * Editer un profile
     */

    public function select_edit_admin($id) {
        $edit_admin = $this->db->select("SELECT * FROM credit_admins WHERE IdAdmin=?", [$id]);
        return $edit_admin;
    }

    /*
     * verification de l'id
     */

    public function verif_id_admin($id) {
        $reponse = $this->db->count("SELECT * FROM credit_admins WHERE IdAdmin=?", [$id]);
        if ($reponse) {
            return $reponse;
        }
    }

    /*
     * editer l'admins
     */

    public function edit_admins($image, $np, $email, $phone, $mdp, $role, $typepie, $nump, $id) {
        return $this->db->insert("UPDATE credit_admins SET image=?, NomprenomsAdmin=?,EmailAdmin=?,PhoneAdmin=?,PasswordAdmin=?,LevelAdmin=?,TypepieceAdmin=?,NumpieceAdmin=? WHERE IdAdmin=?", [$image, $np, $email, $phone, $mdp, $role, $typepie, $nump, $id]);
    }

}
