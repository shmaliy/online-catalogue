<div class="install">
	<form name="inst" method="post" action="javascript:call('core', 'installation', getform('inst'));">
		<input name="dbhost" type="text" />����<br /><br />
		<input name="dbuser" type="text" />������������ ��<br /><br />
		<input name="dbpassword" type="password" />������ ��<br /><br />
		<input name="dbname" type="text" />��� ��<br /><br />
		<input name="dbprefix" type="text" />������� ������<br /><br />
		<input name="login" type="text" />����� ��������������<br /><br />
		<input name="password" type="password" />������ ��������������<br /><br />
		<input name="email" type="text" />E-mail ��������������<br /><br />
		<input class="btn" type="image" src="{#basedir#}/images/button_install.png" /><br /><br />
	</form>
	<div id="inst_stat">&nbsp;</div>
</div>