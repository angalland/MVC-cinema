<?php

// catégorise virtuellement la class, on pourra l' "use" sans connaitre son emplacement physique
namespace Model;

// méthode qui se connecte a la bbd, elle est abstract car on n'instanciera pas la class Connect, on accedera juste a la méthode seConnecter()
abstract class Connect {

    const HOST = "localhost";
    const DB = "cinema";
    const USER = "root";
    const PASS = "";

    public static function seConnecter() {
        try {
            return new \PDO(
                "mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS);
        } catch(\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
