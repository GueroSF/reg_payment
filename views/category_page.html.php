<?php /** @var $this \model\views\ViewCategory */?>
<?php foreach ($this->getCategory() as $category): ?>
	<div class="month<?php if ($category['sum'] == 0) echo ' hide'?>">
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
<div class="button_for_view_if_zero">
    <button>Показать скрытые</button>
</div>