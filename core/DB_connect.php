<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Created by IntelliJ IDEA.
 * User: Kernel
 * Date: 07/07/2022
 * Time: 12:50
 */
class database {

    //put your code here
    private $host = 'localhost';
    private $dbase = 'credit_database';
    private $user = 'root';
    private $password = '';
    private $db;

    public function __construct($host = null, $user = null, $password = null, $dbase = null) {
        if ($host != 0) {
            $this->host = $host;
            $this->dbase = $dbase;
            $this->user = $user;
            $this->password = $password;
        }
        try {
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbase", $this->user, $this->password);
            $this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print 'ERREUR DE CONNEXION AU SYSTEME! ' . $e->getMessage();
            exit();
        }
    }

    /**
     * Fonction d'execution des requetes d'insertion
     */
    public function insert($sql, $data = array()) {
        $req = $this->db->prepare($sql);
        return $req->execute($data);
    }

    /*
     * compte
     */

    public function count($sql, $data = array()) {
        $req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->rowCount();
    }

    public function select($sql, $data = array()) {
        $req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function Show($sql, $data = array()) {
        $req = $this->db->prepare($sql);
        $req->execute($data);
        $req->rowCount();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

}
