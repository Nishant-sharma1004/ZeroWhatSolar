<?php
namespace App\Models;
use CodeIgniter\Model;

class Blog_model extends Model
{

    function get_blog($limit = 6, $url = '')
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
        if($limit != ''){
            $builder->limit($limit);
        }
        $result = $builder->get();

        if (!empty($url)) {
            return $result->getRow();
        } else {
            return $result->getResult();
        }
    }
}
?>