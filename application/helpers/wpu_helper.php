<?php 

function check_access($id_role, $id_menu, $id_parent){
	$ci = get_instance();
	$ci->db->where('id_role', $id_role);
	$ci->db->where('id_menu', $id_menu);
	$ci->db->where('id_kategori', $id_parent);
	$result = $ci->db->get('user_access_menu');
	if($result->num_rows() > 0){
		return "checked='checked'";
	}
}



?>