<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function get($dt)
    {
        $field = array('t1.id_user',
                        't1.name',
                        't1.username'
        );
        
        $columns = implode(', ', $field);
       

        $sql  = "SELECT {$columns} FROM user t1 LEFT JOIN user_group t2 ON t1.id_user_group = t2.id_user_group";
        //debug($sql);
        // kolom 0 tidak terpakai jika menggunakan nomor     
        /** $search_0 = $dt['columns'][0]['search']['value'];
        if (!empty($search_0)) {
            $where .= "AND " .$field[0] . ' LIKE "%' . $search_0 . '%" ';
        } **/
       
        // where
        $where = ' WHERE t1.is_delete = "f" '; //Beri space di awal dan akhir
        $search_name = $dt['columns'][1]['search']['value'];
        if (!empty($search_name)) {
            $where .= search_like('t1.name', $search_name);
        }
        $search_username = $dt['columns'][2]['search']['value'];
        if (!empty($search_username)) {
            $where .= search_like('t1.username', $search_username);
        }
        if(!empty($dt['search']['value'])) {
            $where .= ' AND t1.id_user_group LIKE "%'.$dt['search']['value'].'%" ';
        }
        
        //debug($where);

        $rowCount = count($this->db->query($sql)->result());
        // order by
        $field_order = array('t1.id_user',
                             't1.name',
                             't1.username'
        );
       
        $order_by = '';
        $order_field = array_values($field_order);
        if($order_field[$dt['order'][0]['column']]) {
            $order_by .= "ORDER BY {$order_field[$dt['order'][0]['column']]} {$dt['order'][0]['dir']} ";
        }
        //debug($order_by);
        
        // limit
        $limit = '';
        if($dt['start'] || $dt['length']) {
            $limit .= "LIMIT {$dt['start']}, {$dt['length']}";
        }
        $merge_query = $sql.$where.$order_by.$limit;
        //debug($merge_query);
        $list = $this->db->query($merge_query);
        $option['draw']            = $dt['draw'];
        $option['recordsTotal']    = $rowCount;
        $option['recordsFiltered'] = $rowCount;
        $option['data']            = array();
        $no                        = $dt['start'] +1;
            foreach ($list->result_array() as $row) {
                $msg = 'Are you sure ?';
                $edit = '';
                $delete = '';
                if($this->general->privilege_check(auth_id_menu(),"update")) {
                    $edit = "<a class='btn btn-primary btn-xs' title='Edit' onClick='edit(".$row['id_user'].")' href='#'><i class='fa fa-pencil-square-o'></i>";
                }
                if($this->general->privilege_check(auth_id_menu(),"delete")) {
                    $delete = "<a onClick=\"return confirm('Are you sure to delete ?');\" class='btn btn-danger btn-xs' title='Delete' href=".site_url($this->router->fetch_class().'/delete/'.$row['id_user'])."><i class='fa fa-trash-o'></i></a>";
                }
                $detail = "
                <a class='btn btn-success btn-xs' title='Detail' onClick='detail(".$row['id_user'].")' href='#'><i class='fa fa-eye'></i></a>
                </a>";
                $option['data'][] = array(
                                $row[0] = $no,
                                $row[1] = $row['name'],
                                $row[2] = $row['username'],
                                $row[3] = $detail.$edit.$delete,
                            );
            $no++;
            }
        echo json_encode($option);
    }

    function insert($field) {
        $this->db->insert('user', $field);
    }

    function get_by_id($id) {
        $where['id_user'] = $id;
        return $this->db->get_where('user', $where);
    }

    function update($id, $field) {
        $this->db->where ('id_user', $id);
        $this->db->update ('user', $field);
    }

    function del($id) {
        $where['id_user'] = $id;
        $val['is_delete'] = 't';
        $this->db->update ('user', $val, $where);
    }
}
/* End of file User_model.php */
/* Location: ./application/models/User_model.php */