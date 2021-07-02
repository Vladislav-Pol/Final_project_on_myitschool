
<div class="fileMen content">
	<h2>Файловая стуктура сайта</h2>
	<div class="functions">
		<a href="/admin/" class="button">Домой</a>
		<a href="/admin/explorer/create_edit/?path=<?="{$arData['path']}&create="?>" class="button">Создать</a>
		<a href="/admin/explorer/uploadFile/?path=<?="{$arData['path']}&upload="?>" class="button">Загрузить файл</a>
	</div>
</div>
<div class="main content">
	<span><?=$arData['path'];?></span><br/><br/>
	<table class="elementList">
		<tbody>
		<?php foreach($arData['dirContent'] as $item):?>
			<tr>
				<td class="actions">
					<?php if($item['name'] != ".."):?>
						<a href="/admin/explorer/delete/?path=<?="{$arData['path']}&del={$item['name']}"?>"><img src="/resources/images/admin/delete.png" alt="delete"></a>
					<?php endif;?>
					<?php if($item['canEdit']):?>
						<a href="/admin/explorer/create_edit/?path=<?="{$arData['path']}&edit={$item['name']}"?>"><img src="/resources/images/admin/edit.png" alt="edit"></a>
					<?php endif;?>
				</td>
				<td class="element">
					<?php if($item['elementType'] == 'dir'):?>
						<a href="/admin/explorer/?path=<?=$item['elementPath']?>">
							<img src="/resources/images/admin/folder.png" alt="folder">
							<?=$item['name']?>
						</a>
					<?php elseif($item['elementType'] == 'file'):?>
						<p>
							<img src="/resources/images/admin/file.png" alt="file">
							<?=$item['name']?>
						</p>
					<?php endif;?>
				</td>
				<td>
					<div class="size">
						<div><?=$item['elementSize']?></div>
					</div>
				</td>
				<td>
					<div class="date">
						<div><?=$item['elementDate']?></div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

</div>
<?php
