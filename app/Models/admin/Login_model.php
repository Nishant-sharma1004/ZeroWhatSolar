<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class Login_model extends Model
{
    public function get_user_detail($email)
    {
        $builder = $this->db->table('admin_users as users');
        $builder->select('users.id, users.name, users.email, users.user_type, users.password, users.token, users.add_date, user_type.update_date');
        $builder->join('user_type', 'user_type.id = users.user_type', 'LEFT');
        $builder->where('users.status', 1);
        $builder->where('user_type.status', 1);
        $builder->orWhere('users.email', $email);
        $query = $builder->get();
        return $query->getRow();
    }
}

