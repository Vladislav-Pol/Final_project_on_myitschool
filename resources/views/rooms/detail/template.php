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
			<?php foreach($arData['rooms'] as $room):?>
				<div class="room_item">
					<a href="/room/<?=$room['id']?>/"><img class="head_title" src="<?=$room['photo']?>" alt="Room photo"></a>
					<div class="description">
						<a href="/room/<?=$room['id']?>/"><h2><?=$room['name']?></h2></a>
						<p><?=$room['description']?></p>
						<ul>
							<li>Площадь</li>
							<li>Кровати</li>
						</ul>
						<div class="description_separator"></div>
						<div class="service_icons">{foreach icon <img src="#" alt="#">}</div>
					</div>
					<div class="item_separator"></div>
					<div class="price"></div>
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>