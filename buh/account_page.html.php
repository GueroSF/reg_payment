<div><a href="?add">Добавить категорию</a></div>
<?php foreach ($accounts as $acc): ?>
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
<div class="month">
	<div class="month_name"><span>Одолжено</span></div>
	<div class="salary">
		<table>
			<tr>
				<td>"-" должен</td>
			</tr>
			<tr>
				<td><?php echo $category5;?></td>
			</tr>
		</table>
	</div>
</div>
<div class="month">
	<div class="month_name">Продукты/бензин</div>
	<div class="salary"><?php echo $prOilSum; ?></div>
</div>
</content>
</body>
</html>