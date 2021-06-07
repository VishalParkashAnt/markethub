<?php
echo '<table id="listcontacts" border="2" class="m-t-30" style="width:100%;"><tr><th class="text-center">'.__d('merchant','Username').'</th><th class="text-center">'.__d('merchant','Email').'</th><!--th class="text-center">Action</th --></tr>';
if(count($result)>0)
{
foreach($result as $users)
{
	$email = $users['email_address'];
	echo '<tr align="center"><td style="width:25%;">';
	echo $users['merge_fields']['FNAME'];
	echo '</td><td style="width:25%;">';
	echo $users['email_address'];
	echo '</td>';
	//echo '<td><a onclick="delete_contacts(\''.$email.'\')"><span class="btn btn-danger"><i class="icon-trash" style="cursor:pointer;"></i></a></td>';
	echo '</tr>';
}
}
else
{
	echo '<tr><td colspan="3" align="center">'.__d('merchant','No Contacts Found').'</td></tr>';
}
echo '</table>';

?>

<style type="text/css">
	table#listcontacts tr > td {
		padding:5px 15px;
		font-weight: 400;
	}
	table#listcontacts tr > th {
		padding:8px 15px;
	}
	table#listcontacts tr > td:first-child{
		text-transform: capitalize;
	}
	table#listcontacts tr > th {
		font-weight: 500;
	}
	table#listcontacts, table#listcontacts tr, table#listcontacts th, table#listcontacts td {
		border: 1px solid rgba(0,0,0,0.1) !important;
	}
</style>
