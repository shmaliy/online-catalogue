<div class="confirm_list">
	<div class="table_filter">
		<div class="filter_left">��������� <select id="category">{#tree#}</select></div>
	</div>
	<table class="ctable" cellspacing="1">
		<thead>
			<tr>
				<th>ID</th>
				<th class="title">���������</th>
			</tr>
		</thead>
		<tbody>
			{#items#}
		</tbody>
	</table>
	<div class="buttons">
		<input type="button" value="��" onclick="call('{#name#}', '_copy', [document.getElementById('category').value, getcheckbox('ctable_contents')])">
		<input type="button" value="���" onclick="modal.hide();">
	</div>
</div>
