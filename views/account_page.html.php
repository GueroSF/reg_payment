<?php /**
 * @var $this \model\ViewFirstPage
 */
?>
<?php foreach ($this->getSumAllAccount() as $acc): ?>
	<div class="month">
		<div class="month_name"><span><?= $acc['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td>Всего</td>
				</tr>
				<tr>
					<td><?= $acc['sum'];?></td>
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<a href="account/<?= $acc['id'];?>">Просмотр</a>
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
				<td><?= $this->getCredits() ?></td>
			</tr>
		</table>
	</div>
</div>
<div class="month">
	<div class="month_name">Продукты/бензин</div>
	<div class="salary"><?= $this->getProductOil() ?></div>
	<div class="view_detail">
			<a href="product_oil">Просмотр</a>
		</div>
</div>
<div class="link_to_add"><a href="category_add">Добавить категорию</a></div>
</content>
</body>
</html>