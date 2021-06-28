<div class="rooms rooms_head">
	<div class="page_title">
		<h1>Номера</h1>
	</div>
	<div class="container">
		<div class="filter">
			<form action=".." name="rooms_filter" method="post">
			</form>
		</div>
		<div class="rooms_list">
			<?php foreach ($arData['rooms'] as $room): ?>
				<div class="room_item">
					<a href="/room/<?= $room['id'] ?>/"><img class="head_image" src="<?= $room['photo'] ?>"
															 alt="Room photo"></a>
					<div class="description">
						<a class="room_name" href="/room/<?= $room['id'] ?>/"><h2><?= $room['name'] ?></h2></a>
						<p><?= $room['description'] ?></p>
						<ul>
							<li>Площадь</li>
							<li>Кровати</li>
						</ul>
						<div class="description_separator"></div>
						<div class="service_icons">
							<?php foreach (['conditioner', 'bathtub', 'shower', 'fan', 'fridge'] as $class => $name): ?>
								<div class="icon <?=$name?>" title="<?=$name?>"></div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="price"></div>
				</div>
				<div class="item_separator"></div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
