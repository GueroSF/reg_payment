<body>
<header><a href="?logOut=exit">Выход</a></header>
<content>
<?php for($i=0;$i<4;$i++): ?>
	<div class="month<?php if($i==2) echo " today";?>">
		<div class="month_name"><span><?php nameMonth($monthDisplay[$i]);?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td><b>Зарплата:</b></td>
				</tr>
				<tr>
					<td>офицально:</td><td><?= $moneyCat[1][$i];?></td>
				</tr>
				<tr>
					<td>не офицально:</td><td><?= $moneyCat[2][$i];?></td>
				</tr>
				<tr>
					<td>Всего:</td><td><?= $moneyCat[1][$i]+$moneyCat[2][$i];?></td>
				</tr>
			</table>
		</div>
		<div class="swallow">
			<table>
				<tr>
					<td><b>Ласточка:</b></td>
				</tr>
				<tr>
					<td><?= $moneyCat[3][$i];?></td>
				</tr>
				<?php if(!empty($moneyCat[4][$i])): ?>
					<tr>
						<td><b>Премия:</b></td>
					</tr>
					<tr>
						<td><?= $moneyCat[4][$i];?></td>
					</tr>
				<?php endif; ?>
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