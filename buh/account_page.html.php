<body>
<header><a href="?logOut=exit">Выход</a></header>
<content>
<?php foreach ($account as $acc): ?>
	<div class="month">
		<div class="month_name"><span><?php echo $acc['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td>Всего</td>
				</tr>
				<tr>
					<td><?php echo $acc['sum'];?></td>
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<a href="?account=<?php echo $acc['id'];?>">Просмотр</a>	
		</div>
	</div>
<?php endforeach; ?>
</content>
</body>
</html>