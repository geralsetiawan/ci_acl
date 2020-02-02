<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {


    function get($dt)
    {
       
        $field = array('t1.id_menu',
                        't1.name',
                        't1.title',
                        't2.read',
                        't2.create',
                        't2.update',
                        't2.delete'
        );
        $columns = implode(', ', $field);
        $id_user_group = ' AND t2.id_user_group = 0 ';
        $disabled = 'disabled';
        if(!empty($dt['search']['value'])) {
            $id_user_group = ' AND t2.id_user_group = "'.$dt['search']['value'].'" ';
            $disabled = '';
        }
        $sql  = "SELECT {$columns} FROM menu t1 LEFT JOIN user_role t2 ON t1.id_menu = t2.id_menu ". $id_user_group;
        // kolom 0 tidak terpakai jika menggunakan nomor     
        /** $search_0 = $dt['columns'][0]['search']['value'];
        if (!empty($search_0)) {
            $where .= "AND " .$field[0] . ' LIKE "%' . $search_0 . '%" ';
        } **/
        // where
        $where = ' WHERE t1.id_menu IS NOT NULL '; //Beri space di awal dan akhir
        $search_title = $dt['columns'][1]['search']['value'];
        if (!empty($search_title)) {
            $where .= search_like('t1.title', $search_title);
        }
       
        //debug($where);

        $rowCount = count($this->db->query($sql)->result());
        // order by
        $field_order = array('t1.id_menu',
                             't1.title',
            
        );
        $order_by = '';
        $order_field = array_values($field_order);
        if($order_field[$dt['order'][0]['column']]) {
            $order_by .= "ORDER BY {$order_field[$dt['order'][0]['column']]} {$dt['order'][0]['dir']} ";
        }

       // debug($order_by);
        
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
                if($row['read'] == 1) {
                    $checked_read = 'checked';
                } else {
                    $checked_read = '';
                }
                if($row['create'] == 1) {
                    $checked_create = 'checked';
                } else {
                    $checked_create = '';
                }
                if($row['update'] == 1) {
                    $checked_update = 'checked';
                } else {
                    $checked_update = '';
                }
                if($row['delete'] == 1) {
                    $checked_delete = 'checked';
                } else {
                    $checked_delete = '';
                }
                $option['data'][] = array(
                    $row[0] = $no,
                    $row[1] = $row['title'],
                    $row[2] = "<input data-size='small' data-style='ios' ".$disabled." ".$checked_read." type='checkbox' name='read' id_menu=".$row['id_menu'].">",
                    $row[3] = "<input data-size='small' data-style='ios' ".$disabled." ".$checked_create." type='checkbox' name='create' id_menu=".$row['id_menu'].">",
                    $row[4] = "<input data-size='small' data-style='ios' ".$disabled." ".$checked_update." type='checkbox' name='update' id_menu=".$row['id_menu'].">",
                    $row[5] = "<input data-size='small' data-style='ios' ".$disabled." ".$checked_delete." type='checkbox' name='delete' id_menu=".$row['id_menu'].">"
                );
            $no++;
            }
        echo json_encode($option);
    }
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */