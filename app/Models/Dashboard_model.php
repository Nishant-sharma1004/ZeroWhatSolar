<?php
namespace App\Models;
use CodeIgniter\Model;

class Dashboard_model extends Model
{

    function get_blog($url = '')
    {
        $builder = $this->db->table('blog_posts as blog');
        $builder->select('blog.*, category.name as category_name');
        $builder->join('blog_categories as category', 'category.id = blog.category_id', 'LEFT');
        if (!empty($url)) {
            $builder->where('blog.url', $url);
        }
        $builder->where('blog.post_status', 'published');
        $builder->where('blog.status', 1);
        $builder->orderBy('published_at', 'DESC');
        $builder->limit(6);
        $result = $builder->get();

        if (!empty($url)) {
            return $result->getRow();
        } else {
            return $result->getResult();
        }
    }

    function get_testimonials(){
        $builder = $this->db->table('testimonials');
        $builder->select('*');
        $builder->where('status', 1);
        $builder->orderBy('created_at', 'DESC');
        $builder->limit(6);
        $result = $builder->get();
        return $result->getResult();
    }

    function insertContact($data){
        $builder = $this->db->table('contact_submissions');
        $builder->insert($data);
        return $this->db->insertID();
    }
}
?>