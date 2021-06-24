<?php
global $dirContent;
?>
<div class="fileMen content"> <!-- todo перелапатить код страницы-->
	<h2>Файловая стуктура сайта</h2>
	<div class="functions">
		<a href="./" class="button">Домой</a>
		<a href="./?path=<?="$path&create="?>" class="button">Создать</a>
		<a href="/admin/explorer/uploadFile/" class="button">Загрузить файл</a>
	</div>

</div>
<div class="main content">
	<span><?=$path;?></span><br/><br/>
	<table class="elementList">
		<tbody>
		<? foreach ($dirContent as $key => $item):
			if($key < 1) continue;?>
			<tr>
				<td class="actions">
					<?if($item != ".."):?>
						<a href="./?path=<?="$path&del=$item"?>"><img src="/image/delete.png" alt="delete"></a>
					<?endif;?>
					<?if(ExplorerModel::canEdit($fullPath . $item)):?>
						<a href="./?path=<?="$path&edit=$item"?>"><img src="/image/edit.png" alt="edit"></a>
					<?endif;?>
				</td>
				<td class="element">
					<?if(is_dir($fullPath . $item)):?>
						<a href="./?path=<?=ExplorerModel::cleanPath($path . "/" . $item)?>">
							<img src="/image/folder.png" alt="folder">
							<?= $item ?>
						</a>
					<?else:?>
						<p>
							<img src="/image/file.png" alt="file">
							<?= $item ?>
						</p>
					<?endif;?>
				</td>
				<td>
					<div class="size">
						<div><?=ExplorerModel::getFileSize($fullPath . $item)?></div>
					</div>
				</td>
				<td>
					<div class="date">
						<div><?=ExplorerModel::getFileDate($fullPath . $item)?></div>
					</div>
				</td>
			</tr>
		<?endforeach; ?>
		</tbody>
	</table>

</div>
<?php
