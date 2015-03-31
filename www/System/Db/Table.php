<?php

abstract class System_Db_Table
{
    protected $_name;
    
    /**
     * 
     * @var PDO $_connection
     * 
     */
    protected $_connection;
    
    public function __construct()
    {
        $this->_connection = System_Registry::get('db');
    }
    
    public function getById($id)
    {
        $sql = 'select * from ' . $this->_name . ' where id = ?';
   
        $sth = $this->_connection->prepare($sql);
        
        $sth->execute(array($id));
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
      
        return $result;
    }

    public function getByCriteria($params)
    {
        $page        = 0;
        $limit       = 5;
        $orderBy     = 'id';
        $orderType   = 'asc';
        $page_link   = 4;
        
        if(isset($params['page'])) {
            if($params['page'] < 1) {
                $page = 0;
            }
            else {
                $page = $params['page'] - 1;
            }
        }
        if(isset($params['limit'])) {
            $limit = $params['limit']; 
            $page = $page * $limit;
        }
        
        if(isset($params['orderby'])) {
            $orderBy = $params['orderby']; 
        }
        
        if(isset($params['ordertype'])) {
            $orderType = $params['ordertype'];
        }
        
        if(isset($params['page_link'])) {
            $page_link = $params['page_link'];
        }
   
        $sql    = 'select * from ' . $this->_name . ' order by ' . $orderBy . ' ' . $orderType . ' limit :page, :limit';
        $sth    = $this->_connection->prepare($sql);
        $sth->bindValue(':page', (int)$page, PDO::PARAM_INT);
        $sth->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
        public function getCount()
    {
        $sql    = 'select count(*) from ' . $this->_name;
        $sth    = $this->_connection->prepare($sql);
        $sth->execute();
        $result = reset($sth->fetchAll(PDO::FETCH_COLUMN));
        return $result;
    }
}