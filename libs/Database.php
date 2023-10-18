<?php

class Database extends PDO
{
    
    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        try{
            parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $erro) {
            echo "Erro => " .$erro->getMessage();
        }
    }
    
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);

        if (count($array) > 1) {
            foreach ($array as $key=> $value) {
                $sth->bindValue(":$key", $value);
            }
        }

        $sth->execute();

        return $sth->fetchAll($fetchMode);
    }
    
    public function insert($sql, $array)
    {
		$sth = $this->prepare($sql);

        foreach ($array as $key=> $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }
    
    public function update($sql, $array)
    {
		$sth = $this->prepare($sql);

        foreach ($array as $key=> $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }
    
    public function delete($sql, $array)
    {
		$sth = $this->prepare($sql);

        foreach ($array as $key=> $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }
	
	    
}