<?php
namespace Baobab;

class Database{
    function where($where){
        return $this;
    }
    
    function order($order) {
        return $this;
    }
    
    function limit($limit){
        return $this;
    }
}
	//index.php
	$db = new Database();
	$db->where('id = 1')->order('order by id')->limit(1);
?>