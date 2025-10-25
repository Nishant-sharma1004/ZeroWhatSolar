<?php
namespace App\Models\admin;
use CodeIgniter\Model;
class Contact_model extends Model
{
    function get_contact_leads($data = [])
    {
        $builder = $this->db->table('contact_submissions');
        $builder->select('*');
        $builder->where('status', 1);
        if (isset($data['filter']) && $data['filter'] != 'all') {
            $builder->where('contact_status', $data['filter']);
        }

        if (isset($data['search'])) {
            $builder->groupStart();
            $builder->like('name', $data['search']);
            $builder->orLike('email', $data['search']);
            $builder->orLike('message', $data['search']);
            $builder->groupEnd();
        }
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_all_contact()
    {
        $builder = $this->db->table('contact_submissions');
        $builder->select('id');
        $builder->where('status', 1);
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_unread_contact()
    {
        $builder = $this->db->table('contact_submissions');
        $builder->select('id');
        $builder->where('contact_status', 'unread');
        $builder->where('status', 1);
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_todays_contact()
    {
        $builder = $this->db->table('contact_submissions');
        $builder->select('id');
        $builder->where('status', 1);
        $builder->where('DATE(created_at)', date('Y-m-d'));
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function save_contact_lead($data)
    {
        $builder = $this->db->table('contact_submissions');
        $builder->insert($data);
        return $this->db->insertID();
    }

    function update_contact_lead($data){
        $builder = $this->db->table('contact_submissions');
        $builder->where('id', $data['id']);
        return $builder->update($data);
    }
}
?>