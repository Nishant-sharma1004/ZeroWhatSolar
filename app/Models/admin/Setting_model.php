<?php
namespace App\Models\admin;
use CodeIgniter\Model;
class Setting_model extends Model
{
    function get_site_settings($setting_key = '')
    {
        $builder = $this->db->table('site_settings');
        $builder->select('*');
        if ($setting_key) {
            $builder->where('setting_key', $setting_key);
        }
        $query = $builder->get();
        if ($setting_key) {
            return $query->getRow();
        } else {
            return $query->getResult();
        }
    }

    function insert_settings($data){
        $builder = $this->db->table('site_settings');
        $builder->insert($data);
        return $this->db->insertID();
    }

    function update_settings($data){
        $builder = $this->db->table('site_settings');
        $builder->where('setting_key', $data['setting_key']);
        $builder->update($data);
        return $this->db->affectedRows();
    }
}
?>