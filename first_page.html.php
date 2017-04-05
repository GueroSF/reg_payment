<body>
<header><a href="?logOut=exit">Выход</a></header>
<content>
<?php for($i=0;$i<4;$i++): ?>
	<div class="month<?php if($i==2) echo " today";?>">
		<div class="month_name"><span><?php nameMonth($monthDisplay[$i]);?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td colspan="2">офицально</td>
				</tr>
				<tr>
					<td><?php echo $moneyCat[1][$i];?></td><td>из 15000</td>
				</tr>
				<tr>
					<td colspan="2">не офицально</td>
				</tr>
				<tr>
					<td><?php echo $moneyCat[2][$i];?></td><td>из 100000</td>
				</tr>
			</table>
		</div>
		<div class="swallow">
			<table>
				<tr>
					<th>Ласточка</th>
				</tr>
				<tr>
					<td>Оплачено</td>
				</tr>
				<tr>
					<td><?php echo $moneyCat[3][$i];?></td>
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<a href="payment.php?month=<?php echo $monthDisplay[$i];?>">Просмотр</a>	
		</div>
	</div>
<?php endfor; ?>
</content>
</body>
</html>