<?php
namespace App\Models;
use CodeIgniter\Model;

class Testimonials_model extends Model
{
    function get_testimonials()
    {
        $builder = $this->db->table('testimonials');
        $builder->select('*');
        $builder->where('testimonials_status', 'approved');
        $builder->where('status', 1);
        $builder->where('featured', 1);
        $builder->orderBy('created_at', 'DESC');
        $builder->limit(1);
        $result = $builder->get();
        return $result->getRow();
    }
}
?>