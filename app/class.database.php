<?php
class PDODB {
    private $_dbh;
    private $_stmt;
	private $_debug = true;
	private $_tmp = array();

    public function __construct($host, $user, $pass, $dbname) {
       // Data source name
		$dsn = 'mysql:dbname='.$dbname.';host='.$host;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_PERSISTENT => true);
		
        try {
            $this->_dbh = new PDO($dsn, $user, $pass, $options);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function query($query) {
		$this->_stmt = $this->_dbh->prepare($query);
	}

    public function bind($placeholder, $value, $type = null) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					break;
			}
		}
		$this->_stmt->bindValue($placeholder, $value, $type);
    }

    public function execute() {
        $this->_queryCounter++;
        return $this->_stmt->execute();
    }

    public function fetchResultSet() {
        $this->execute();
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchResult() {
        $this->execute();
        return $this->_stmt->fetch(PDO::FETCH_ASSOC);
    }

    //if called inside a transaction, must call it before closing the transaction!!!!!!
    public function lastInsertId() {
        return $this->_dbh->lastInsertId();
    }

    // Transactions
    public function beginTransaction() {
        return $this->_dbh->beginTransaction();
    }

    public function endTransaction() {
        return $this->_dbh->commit();
    }

    public function cancelTransaction() {
        return $this->_dbh->rollBack();
    }

    // returns number of rows updated, deleted, or inserted
    public function rowCount() {
        return $this->_stmt->rowCount();
    }

    public function getQueryCount() {
        return $this->_queryCounter;
    }

    public function debugDumpParams() {
        return $this->_stmt->debugDumpParams();
    }
}


