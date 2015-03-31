<?php

abstract class System_Controller {
    
    /**
     *
     * @var System_View $view
     *  
     */
   
    public $view;
    public $args;
    
    protected $_userId;


    protected function _getArguments()
    {
        $count = count($this->args);
        $arguments = array();
        for($i = 0; $i < $count - 1; $i += 2) {
            $arguments[$this->args[$i]] = $this->args[$i+1];
        }
        
        return $arguments;
    }
    
    public function __construct() {
        
        $this->view = new System_View();
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
    
     public function getParamByKey($key)
    {
        return !empty($_REQUEST[$key]) ? $_REQUEST[$key] : NULL;
    }
    
    public function getAllParams()
    {
        return $_REQUEST;
    }
    
    


    protected function setSessParam($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    protected function getSessParam($key)
    {   
        if(!empty($_SESSION)) {
            return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : NULL;
        }
        return NULL;
    }
    
  
    
}
