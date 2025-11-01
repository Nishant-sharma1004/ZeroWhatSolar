<?php
namespace App\Models;
use CodeIgniter\Model;

class Project_model extends Model
{
    function getAllProjects(){
        $builder = $this->db->table('projects');
        $builder->select('*');
        $builder->where('status', 1);
        $builder->orderBy('created_at', 'DESC');
        $result = $builder->get();
        return $result->getResult();
    }
}