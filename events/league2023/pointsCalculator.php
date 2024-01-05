<h1 id="calculator"><u>League 2023 Points Calculator</u></h1>
<?php include 'TwitchMap.php' ?>
<p id="warning">ATTENTION: This tool heavily relies on the sheet (and therefore your speedrun.com submissions) to be accurate. It will not update automatically if you do PB, thus I highly suggest to submit everything you got to speedrun.com to make use of this tool!</p>
<table border=1 id="pointsTable">
	<tr>
		<td>
			<select id="runners">
				<option id="none" selected="selected">Please Select A Runner</option>
			</select>
		</td>
		<td>
			Your Rank:
		</td>
		<td>
			Your Time:
		</td>
		<td>
			Your Points:
		</td>
		<td>
			Rank To Beat:
		</td>
		<td>
			Time To Beat:
		</td>
		<td>
			Points To Gain:
		</td>
	</tr>
	<tr>
		<td>GS1</td>
		<td id="gs1_rank1"></td>
		<td id="gs1_time1"></td>
		<td id="gs1_points1"></td>
		<td> <select id="gs1_rank0" style="width: 100%;"></select></td>
		<td id="gs1_time0"></td>
		<td id="gs1_points0"></td>
	</tr>
	<tr>
		<td>GS81</td>
		<td id="gs81_rank1"></td>
		<td id="gs81_time1"></td>
		<td id="gs81_points1"></td>
		<td><select id="gs81_rank0" style="width: 100%;"></select></td>
		<td id="gs81_time0"></td>
		<td id="gs81_points0"></td>
	</tr>
	<tr>
		<td>GS131</td>
		<td id="gs131_rank1"></td>
		<td id="gs131_time1"></td>
		<td id="gs131_points1"></td>
		<td><select id="gs131_rank0" style="width: 100%;"></select></td>
		<td id="gs131_time0"></td>
		<td id="gs131_points0"></td>
	</tr>
	<tr>
		<td>MNE70</td>
		<td id="mne70_rank1"></td>
		<td id="mne70_time1"></td>
		<td id="mne70_points1"></td>
		<td><select id="mne70_rank0" style="width: 100%;"></select></td>
		<td id="mne70_time0"></td>
		<td id="mne70_points0"></td>
	</tr>
	<tr>
		<td>MNE125</td>
		<td id="mne125_rank1"></td>
		<td id="mne125_time1"></td>
		<td id="mne125_points1"></td>
		<td><select id="mne125_rank0" style="width: 100%;"></select></td>
		<td id="mne125_time0"></td>
		<td id="mne125_points0"></td>
	</tr>
	<tr>
		<td>ZAR12</td>
		<td id="zar12_rank1"></td>
		<td id="zar12_time1"></td>
		<td id="zar12_points1"></td>
		<td><select id="zar12_rank0" style="width: 100%;"></select></td>
		<td id="zar12_time0"></td>
		<td id="zar12_points0"></td>
	</tr>
	<tr>
		<td>ZAR96</td>
		<td id="zar96_rank1"></td>
		<td id="zar96_time1"></td>
		<td id="zar96_points1"></td>
		<td><select id="zar96_rank0" style="width: 100%;"></select></td>
		<td id="zar96_time0"></td>
		<td id="zar96_points0"></td>
	</tr>
	<tr>
		<td>ZAR170</td>
		<td id="zar170_rank1"></td>
		<td id="zar170_time1"></td>
		<td id="zar170_points1"></td>
		<td><select id="zar170_rank0" style="width: 100%;"></td>
		<td id="zar170_time0"></td>
		<td id="zar170_points0"></td>
	</tr>
	<tr>
		<td>Total</td>
		<td colspan=2></td>
		<td id="total"></td>
		<td colspan=2></td>
		<td id="total_gain"></td>
	</tr>
</table>
