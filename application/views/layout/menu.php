<?php
$menu = $this->db->query("SELECT * from menu WHERE name NOT LIKE '%.%' ")->result();
    foreach($menu as $main) {
        $id = $main->id_menu;
        $name = $main->name;
        $sub_menu = $this->db->query("SELECT * from menu WHERE id_menu != '$id' AND SUBSTRING_INDEX(name,'.',1) = '$name'");
        // CHILD ONE
        if ($sub_menu->num_rows() > 0) {
            $where['url'] = $this->router->fetch_class();
            $rows = $this->db->get_where('menu', $where)->row_array();
            $xpl = explode('.', $rows['name']);
            $arr = $xpl[0];
            if($arr == $main->name) {
                $class = 'active';
            } else {
                $class = '';
            }           
            if($this->general->privilege_check($main->id_menu,'read')) { 
            echo "<li class='treeview ".$class."'>" . anchor($main->url, '<i class="' . $main->icon . '"></i><span>' . $main->title .
                '</span><span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>');
            }
            echo "<ul class='treeview-menu'>";
                foreach ($sub_menu->result() as $sub) {
                    $xp = explode('.', $sub->name);
                        if(!empty($xp[2])) {
                            continue;
                        }
                    $ids = $sub->id_menu;
                    $sub_name = $sub->name;
                    $sub_menu_two = $this->db->query("SELECT * from menu WHERE id_menu != '$ids' AND SUBSTRING_INDEX(name,'.',2) = '$sub_name'");
                        // CHILD TWO
                    if ($sub_menu_two->num_rows() > 0) {
                        $class = '';
                        $where['url'] = $this->router->fetch_class();
                        $rows = $this->db->get_where('menu', $where)->row_array();
                        $xpl = explode('.', $rows['name']);
                        $count = count($xpl);
                        if($count  >= 3) {
                        $arr = $xpl[0].".".$xpl[1];
                        if($arr == $sub->name) {
                            $class = 'active';
                            }         
                        }   
                         if($this->general->privilege_check($sub->id_menu,'read')) {
                            echo "<li class=' treeview ".$class."'>" . anchor($sub->url, '<i class="' . $sub->icon . '"></i><span>' . $sub->title .'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>');
                         }
                            echo "<ul class='treeview-menu'>";
                            foreach ($sub_menu_two->result() as $sub_two) {
                                $xps = explode('.', $sub_two->name);
                                        if(!empty($xps[3])) {
                                            continue;
                                        }
                                $idx = $sub_two->id_menu;
                                $sub_name2 = $sub_two->name;
                                $sub_menu_three = $this->db->query("SELECT * from menu WHERE id_menu != '$idx' AND SUBSTRING_INDEX(name,'.',3) = '$sub_name2'");
                                // CHILD THREE
                                if ($sub_menu_three->num_rows() > 0) {
                                    $class = '';
                                    $where['url'] = $this->router->fetch_class();
                                    $rows = $this->db->get_where('menu', $where)->row_array();
                                    $xpl = explode('.', $rows['name']);
                                    $count = count($xpl);
                                    if($count >= 3) { // JUMLAH EXPLODE ADA 4 TAPI HANYA DI AMBIL 3 PECAHAN
                                    $arr = $xpl[0].".".$xpl[1].".".$xpl[2];
                                    if($arr == $sub_two->name) {
                                        $class = 'active';
                                    } else {
                                        
                                        }        
                                    }
                                    if($this->general->privilege_check($sub_two->id_menu,'read')) {
                                        echo "<li class='treeview ".$class." '>" . anchor($sub_two->url, '<i class="' . $sub_two->icon . '"></i><span>' . $sub_two->title .'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>');
                                     }
                                    echo "<ul class='treeview-menu'>";
                                        foreach ($sub_menu_three->result() as $sub_three) {
                                            if($this->general->privilege_check($sub_three->id_menu,'read')) {
                                            echo "<li class=".active_class_link($sub_three->url).">" . anchor($sub_three->url, '<i class="' . $sub_three->icon . '"></i>' . $sub_three->title) . "</li>";
                                            }
                                        }
                                    echo"</ul></li>";

                                } else {
                                    if($this->general->privilege_check($sub_two->id_menu,'read')) {
                                     echo "<li class=".active_class_link($sub_two->url).">" . anchor($sub_two->url, '<i class="' . $sub_two->icon . '"></i><span>' . $sub_two->title) . "</span></li>";
                                    }
                                }
                            }
                            echo"</ul></li>";

                        } else {
                             if($this->general->privilege_check($sub->id_menu,'read')) {
                                echo "<li class=".active_class_link($sub->url).">" . anchor($sub->url, '<i class="' . $sub->icon . '"></i><span>' . $sub->title) . "</span></li>";
                             }  
                        }
                }
            echo"</ul></li>";
        } else {

            if($this->general->privilege_check($main->id_menu,'read')) {
                 echo "<li class=".active_class_link($main->url).">" . anchor($main->url, '<i class="' . $main->icon . '"></i><span>' . $main->title) . "</span></li>"; 
            }
        }
    }
?>