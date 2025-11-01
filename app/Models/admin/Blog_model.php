<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class Blog_model extends Model
{

    function get_blog_count()
    {
        $builder = $this->db->table('blog_posts as bp');
        $builder->select('COUNT(bp.id) as count');
        $builder->where('bp.status', 1);
        $query = $builder->get();
        return $query->getRow()->count;
    }

    function get_blog_posts()
    {
        $builder = $this->db->table('blog_posts as bp');
        $builder->select('bp.id, bp.title, bp.url, bp.excerpt, bp.post_status, bp.slug, bc.name as category, bp.created_at');
        $builder->join('blog_categories as bc', 'bc.id = bp.category_id', 'left');
        $builder->where('bp.status', 1);
        $builder->orderBy('bp.created_at', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_blog_categories()
    {
        $builder = $this->db->table('blog_categories');
        $builder->select('id, name');
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function checkBlogPost($slug){
        $builder = $this->db->table('blog_posts');
        $builder->select('id');
        $builder->where('slug', $slug);
        $query = $builder->get();
        return $query->getRow();
    }

    function add_blog_post($data)
    {
        $builder = $this->db->table('blog_posts');
        $builder->insert($data);
        return $this->db->insertID();
    }

    function get_blog_post_by_id($url)
    {
        $builder = $this->db->table('blog_posts');
        $builder->select('*');
        $builder->where('url', $url);
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getRow();
    }

    function update_blog_post($data)
    {
        $builder = $this->db->table('blog_posts');
        $builder->where('url', $data['url']);
        $builder->update($data);
        return $this->db->affectedRows();
    }
}

