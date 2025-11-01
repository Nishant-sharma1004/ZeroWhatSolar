<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class Projects_model extends Model
{
    function project_categories()
    {
        $builder = $this->db->table('project_categories');
        $builder->select('*');
        $builder->orderBy('name', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_project_count()
    {
        $builder = $this->db->table('projects');
        $builder->select('COUNT(id) as count');
        $builder->where('status', '1');
        $query = $builder->get();
        return $query->getRow()->count;
    }

    function get_projects()
    {
        $builder = $this->db->table('projects p');
        $builder->select('p.*, pc.name as category_name');
        $builder->join('project_categories pc', 'pc.id = p.category_id', 'left');
        $builder->orderBy('p.created_at', 'DESC');
        $builder->where('p.status', '1');
        $query = $builder->get();
        return $query->getResult();
    }

    function save_project($data)
    {
        $builder = $this->db->table('projects');
        $builder->insert($data);
        return $this->db->insertID();
    }

    function get_project_by_url($url)
    {
        $builder = $this->db->table('projects');
        $builder->select('*');
        $builder->where('url', $url);
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getRow();
    }

    function update_project($data)
    {
        $builder = $this->db->table('projects');
        $builder->where('url', $data['url']);
        return $builder->update($data);
    }
}