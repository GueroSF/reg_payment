<?php /** @var $this \model\ViewCategory */?>
<?php foreach ($this->getCategory() as $category): ?>
	<div class="month">
		<div class="month_name"><span><?= $category['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td>Всего</td>
				</tr>
				<tr>
					<td><?= $category['sum'] ?></td>
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<a href="<?= $this->iAccountId?>/category/<?= $category['id'];?>">Просмотр</a>
		</div>
	</div>
<?php endforeach; ?>
</content>
</body>
</html>