<?php 
namespace App\Models;
use CodeIgniter\Model;

class Common_model extends Model{
    function get_site_setting(){
        $builder = $this->db->table('site_settings');
        $builder->select('setting_key, setting_value');
        $result = $builder->get();
        return $result->getResult();
    }
}
?>