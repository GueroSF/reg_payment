<body>
<header><a href="?logOut=exit">Выход</a></header>
<content>
<?php foreach ($categorys as $category): ?>
	<div class="month">
		<div class="month_name"><span><?php echo $category['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td>Всего</td>
				</tr>
				<tr>
					<td><?php echo $category['sum'];?></td>
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<a href="?category=<?php echo $category['id'];?>&account=<?php echo $id;?>">Просмотр</a>	
		</div>
	</div>
<?php endforeach; ?>
</content>
</body>
</html>