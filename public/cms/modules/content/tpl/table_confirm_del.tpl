<div class="confirm_list">
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
		<input type="button" value="��" onclick="call('{#name#}', '_delete', ['del', getcheckbox('ctable_contents')])">
		<input type="button" value="���" onclick="modal.hide();">
	</div>
</div>
