<?php

class PPI_DataSource_Mongo {
    protected $conn = array();

	function __construct() {

	}

	function getDriver(array $config) {
        if (!class_exists('Mongo')) {
            throw new PPI_Exception('Mongo extension is missing');
        }

        $dsn =  'mongodb://'
            .((isset($config['user'])) ?
                $config['user'] . ((isset($config['pass'])) ? ':' . $config['pass'] : '') .'@'
                : '')
            .((isset($config['host'])) ? $config['host'] : 'localhost')
            .((isset($config['port'])) ? ':' . $config['port'] : '');

        if (empty($this->conn[$dsn])) {

            if (empty($config['options'])) {
                $config['options'] = array();
            }

            $this->conn[$dsn] = new Mongo($dsn, $config['options']);
        }
        
        if (!empty($config['database'])) {
            return $this->conn[$dsn]->selectDB($config['database']);
        } 
        return $this->conn[$dsn];
    }

}
