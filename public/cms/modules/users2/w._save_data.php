<?php
	function _save_data($data){
		$params = (class_exists('params', false)) ? new params() : false;
		$id = $data[$this->name]['db_id'];
		$sql['name'] = $data[$this->name]['username'];
		$sql['login'] = $data[$this->name]['login'];
		$sql['usertype'] = $data[$this->name]['usertype'];
		$sql['block'] = $data[$this->name]['block'];
		$sql['email'] = $data[$this->name]['email'];
		$sql['image'] = $data[$this->name]['image'];
		$sql = ($params) ? $params->adv_save($data[$this->name], $sql, $this->name) : $sql;
		
		if ($id == 'new'){
			$sql['password'] = md5($data[$this->name]['password']);
			$sql['register_date'] = date('Y-m-d H:i:s');
			if ($sql['login'] != '' && $sql['usertype'] != '0' && $sql['email'] != '' && $data[$this->name]['password'] != '' && $data[$this->name]['password2'] != ''){
				if ($data[$this->name]['password'] == $data[$this->name]['password2']){
					if ($this->insert($sql)){$return = 'true';}
					else { $return[] = array('call', 'message', "������ ���������� ������������"); }
				}else{
					$return[] = array('call', 'message', "������ ������ ���������");
				}
			}else{
				$return[] = array('call', 'message', "����: '<b>�����</b>', '<b>E-mail</b>', '<b>���������</b>', '<b>������</b>' ������ ���� ��������� ���������");
			} 
		}else{
			settype($id,"integer");
			if ($sql['login'] != '' && $sql['usertype'] != '0' && $sql['email'] != ''){
				if ($data[$this->name]['password'] == $data[$this->name]['password2']){
					if($data[$this->name]['password'] != ''){$sql['password'] = md5($data[$this->name]['password']);}
				}else{
					$return[] = array('call', 'message', "������ ������ ���������");
				}
				if ($this->update($sql, $id)){$return = 'true';}
				else { $return[] = array('call', 'message', "������ �������������� ������������"); }				
			}else{
				$return[] = array('call', 'message', "����: '<b>�����</b>', '<b>E-mail</b>', '<b>���������</b>' ������ ���� ��������� ���������");
			} 
		}
		return $return;
	}	
?>