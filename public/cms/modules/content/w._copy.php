<?php
	function _copy($data){
		$categories = new categories();
		if ($data[0] != 'confirm'){
			if ($data[1] == 'null'){ return array(array('call', 'message', "������ ���������")); }
			else{
				$errors = array();
				foreach ($data[1] as $item){
					$elem = $this->get($item);
					$elem['parent_id'] = $data[0];
					$elem['checked_out'] = '0';
					$elem['checked_out_time'] = '0000-00-00 00:00:00';
					$elem['ordering'] = 1;
					if (!$this->insert($elem)){ $errors[] = $item.' (������ �����������)'; }
				}
				if (count($errors)==0){
					$return[] = array('assign', $this->name.'_table', 'innerHTML', $this->table());
					$return[] = array('call', 'modal.hide');
					$return[] = array('sleep', 10);
					$return[] = array('call', 'message', '�������(�) �����������');
					return $return;
				}else return array(array('call', 'message', "������ ��������� ID:<br />&nbsp;&nbsp;&nbsp;".implode(';<br />', $errors)));
			}
		}else{
			if ($data[1] == 'null'){ return array(array('call', 'message', "�� ������ �� ���� �������")); }
			else{
				foreach ($data[1] as $item){
					$elem = $this->get($item); 
					$o['{#id#}'] = "$item";
					$o['{#title#}'] = ($elem['title_alias'] != '') ? $elem['title'].' ( '.$elem['title_alias'].' ) ' : $elem['title'];
					$out['{#items#}'] .= $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_row.tpl", $o);
				}
				$p[] = 'width=500&height=265&title=�����������&close=true';
				$out['{#basedir#}'] =  BASEDIR;
				$out['{#name#}'] =  $this->name;
				$out['{#tree#}'] = $categories->tree(0, 0, $_SESSION['cms']['mod'][$this->name]['parent']);
				$p[] = $this->core->tpl->assign("modules/$this->name/tpl/table_confirm_copy.tpl", $out);
				return array(array('call', 'modal.show', $p));				
			}
		}
	}
?>