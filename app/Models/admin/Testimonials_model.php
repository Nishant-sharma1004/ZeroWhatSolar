<?php 
namespace App\Models\admin;
use CodeIgniter\Model;

class Testimonials_model extends Model
{
    function get_testimonials(){
        $builder = $this->db->table('testimonials');
        $builder->select('*');
        $builder->where('status',1);
        $builder->orderBy('created_at','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_testimonial_detail($url){
        $builder = $this->db->table('testimonials');
        $builder->select('*');
        $builder->where('url',$url);
        $builder->where('status',1);
        $query = $builder->get();
        return $query->getRow();
    }

    function save_testimonial($data){
        $builder = $this->db->table('testimonials');
        $builder->insert($data);
        return $this->db->insertID();
    }

    function update_testimonial($data){
        $builder = $this->db->table('testimonials');
        $builder->where('url', $data['url']);
        $builder->update($data);
        return $this->db->affectedRows();
    }
}

?>