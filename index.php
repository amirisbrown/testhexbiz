<?php

	include_once __DIR__.'/autoload.php';
	include_once __DIR__.'/includes/global.php';
	require_once  __DIR__ . '/includes/config.php';
	require_once __DIR__.'/includes/currentRates.php';

	$rates    = new CurrentRates(new Config());
	$rateData = $rates->getRateData();

	if (isset($_GET['lang']) && !empty($_GET['lang']) && ($_GET['lang'] == 'en'))
	{
		require_once __DIR__ . '/includes/language/enlang.php';
		$language = 'en';
	}
	else
	{
		require_once __DIR__ . '/includes/language/cnlang.php';
		$language = 'cn';
	}

?>

<html lang="zh-Hans">

<head>

	<meta charset="utf-8">
	<meta name="theme-color" content="#000000">
	<meta name="description" content="The most rewarding way to support HEX adopion!">
	<meta name="_csrf" content="<?php echo $_SESSION['token']; ?>"/>

	<meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/>
	<title>HEX.business</title>

	<link rel="icon" href="./favicon.ico">
	<link rel="apple-touch-icon" href="./static/media/logo192.png">
	<!--<link rel="stylesheet" href="./static/css/normalize.css">-->
	<link href="./static/css/additional.css" rel="stylesheet">
	<link href="./static/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="./static/css/gallery.prefixed.css">
	<link rel="stylesheet" href="./static/css/gallery.theme.css?v=6">
	<link rel="stylesheet" href="./static/css/modal.css?v=6">
	<link rel="stylesheet" href="./static/css/basic.css?v=0.0.2">

</head>


<body>

<div id="root">
	<a name="outsideMenu"></a>
	<div class="App">
		<div class="menu" id="menu"><a name="menu"></a>
			<div class="menu-item  closeButton">
				<a href="#outsideMenu" id="menuclose">
					<img class="close-button" src="data:image/png;base64,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"
					> 
				</a>
			</div>

			<div class="menu-title row" lang="en">
				hex
			</div>

			<div class="menu-item ">
				<a href="https://hex.win/" lang="en">
					hex
				</a>
			</div>

			<div class="menu-item ">
				<?php echo $phrases['aa_lobby'] ?>
			</div>

			<div class="menu-title row">
				<?php echo $phrases['our_project'] ?>
			</div>

			<div class="menu-item ">
				<a href="./static/media/hxylitepaper.pdf" lang="en">
					<?php echo $phrases['litepaper'] ?>
				</a>
			</div>

			<div class="menu-item ">
				<a href="#hexmobile" lang="en">
					<?php echo $phrases['hex_mobile'] ?>
				</a>
			</div>

			<div class="menu-item ">
				<a href="#hexcredit" lang="en">
					<?php echo $phrases['hex_credit'] ?>
				</a>
			</div>

			<div class="menu-item ">
				<a href="#hexmoney" lang="en">
					<?php echo $phrases['hex_money'] ?>
				</a>
			</div>

			<div class="menu-item " lang="en">
				hex pool
			</div>

			<div class="menu-item " lang="en">
				<?php echo $phrases['hex_stable_coming_soon'] ?>
			</div>


			<div class="menu-title row">
				<?php echo $phrases['entertainment'] ?>
			</div>

			<div class="menu-item ">
				<a href="https://hexlotto.com">
					<?php echo $phrases['hex_lotto_rocket'] ?>
				</a>
			</div>

			<div class="menu-item " lang="en">
				<?php echo $phrases['hex_lotto_stake'] ?>
			</div>

			<div class="menu-item ">
				<?php echo $phrases['hex_bet_coming_soon'] ?>
			</div>

			<div class="menu-item ">
				<a href="#hexplay" lang="en">
					<?php echo $phrases['hex_play'] ?>
				</a>
			</div>

			<div class="menu-item " lang="en">
				<a href="https://hextra.win">
					<?php echo $phrases['hextra'] ?>
				</a>
			</div>
			<div class="menu-item " lang="en">
				<a href="https://hex.academy/">
					<?php echo $phrases['hex_academy'] ?>
				</a>
			</div>

			<div class="menu-title row">
				<?php echo $phrases['statistics'] ?>
			</div>

			<div class="menu-item " lang="en">
				<a href="https://hex.vision">
					<?php echo $phrases['hex.vision'] ?>
				</a>
			</div>

			<div class="menu-item " lang="en">
				<a href="https://uniswap.hex.vision">
					<?php echo $phrases['uniswap.hex.vision'] ?>
				</a>
			</div>

		</div>


		<div class="headroom-wrapper " style="height: 45px;">

			<div style="position: relative; top: 0px; left: 0px; right: 0px; z-index: 1; transform: translate3d(0px, 0px, 0px);"
			     class="headroom headroom--unfixed">

				<nav class="App-header bottom-shadow navbar navbar-expand navbar-light desktop-nav">

					<a href="#" class="navbar-brand">

						<img src="data:image/png;base64,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" alt="hex business logo" class="top-image" lang="en"> <?php echo $phrases['beta'] ?>
					</a>

					<ul class="navbar-nav ml-auto">
						<li class="my-auto hand" id='approve'>
							<img src="./static/media/metamask.2c92daf3.png" class="metamask-button"
							     alt="Connect MetaMask">
						</li>
						<li class="my-auto hand margin-5 d-flex">
							<a href="./index.php?lang=en"><img src="./static/media/entranslation.png" alt="Use English" class=" "> </a>
						</li>
						<li class="my-auto hand margin-30 d-flex">
							<a href="./index.php?lang=cn"><img src="./static/media/cntranslation.png" alt="使用中文" class=" "> </a>
						</li>

						<li class="my-auto">
							<div>
								<a href="#menu" class="openButton" id="menuopen">
									<!-- will clean this mess up later -->
									<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG0AAABVCAYAAABD0WqWAAABhGlDQ1BJQ0MgcHJvZmlsZQAAKJF9kTtIw0Acxr8+pKIVQTuIOGSoThZ8IY5ahSJUCLVCqw4ml76gSUOS4uIouBYcfCxWHVycdXVwFQTBB4iTo5Oii5T4v6TQIsaD4358d9/H3XeAv15mqhkcA1TNMlKJuJDJrgqhVwTRh26MIywxU58TxSQ8x9c9fHy9i/Es73N/jh4lZzLAJxDPMt2wiDeIpzctnfM+cYQVJYX4nHjUoAsSP3JddvmNc8FhP8+MGOnUPHGEWCi0sdzGrGioxFPEUUXVKN+fcVnhvMVZLVdZ8578heGctrLMdZpDSGARSxAhQEYVJZRhIUarRoqJFO3HPfyDjl8kl0yuEhg5FlCBCsnxg//B727N/OSEmxSOAx0vtv0xDIR2gUbNtr+PbbtxAgSegSut5a/UgZlP0mstLXoE9G4DF9ctTd4DLneAgSddMiRHCtD05/PA+xl9UxbovwW61tzemvs4fQDS1FXyBjg4BEYKlL3u8e7O9t7+PdPs7wdVH3KbR7qlWwAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB+QEEg0eKkmzr7oAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAABxUlEQVR42u3bsWoUURyF8e9EsA0ItmkjphSsFAsrYUEEC0EEq4ASyBsIQp5BMY1g4QMIC1ZCGsUiIAQCVkKqtIFAwObajMNkUdJEcv/y/WCbne4c7szswgGVk79daK3dAVaN6ML8BHaS/DiztNbaM2ALuGJuXfgCPE/y7Y+ltdbeAU/MqTsnwL0kO6dKG07YK/Pp1gGwluR4aSjsEvDSXLq2ArwAWBq+uAlcNZfuPZiWtmIeZU7bWNqxeZRwNC1tzzxK2BtLS3IAzM2ke9uLr/yrwFdg2Wy69CHJ/entkSTfgdveKrs9YY/HrhavttYuAxvALeCGb5YXZnf4vP/9T4gkSZIkSZIkSZIkSZIk6Tw53+2X893CnO8W5Xy3KOe7BTnfLcr5btHT5ny3GOe7BTnfLcj5bjHOdwueMOe7BTjflSRJkiRJkiRJkiRJkqR/yvluv5zvFnbmfPct8NScunMCzJJ8OlVaa20deGM+3ToCriU5nM53t8yla8vAJjjfrebhtDRHFjU43y36M8D5bjG7Y2nDfPejmXTv9eIr/3XgM853ezVPMpveHkmyD9wF9s2nO9vAo7GrxavOd7t6fjnf/V/8AkkMlOopfThoAAAAAElFTkSuQmCC"
									     class="menu-icon" alt="menu">
								</a>
							</div>
						</li>
					</ul>
				</nav>
				<nav class="App-header bottom-shadow navbar navbar-expand navbar-light mobile-nav">
					<div class='d-flex mobile-hamb'>
						<a href="#menu" class="navbar-brand">
							<img src="data:image/png;base64,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"
								alt="hex business logo" class="top-image" lang="en"> <?php echo $phrases['beta'] ?>
						</a>

						<ul class="navbar-nav ml-auto">
							<li class="my-auto hand" id='approvemobile'>
								<img src="./static/media/metamask.2c92daf3.png" class="metamask-button"
									alt="Connect MetaMask">
							</li>
							<li class="my-auto">
								<div>
									<a href="#menu" class="openButton" id="mobilemenuopen">
										<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG0AAABVCAYAAABD0WqWAAABhGlDQ1BJQ0MgcHJvZmlsZQAAKJF9kTtIw0Acxr8+pKIVQTuIOGSoThZ8IY5ahSJUCLVCqw4ml76gSUOS4uIouBYcfCxWHVycdXVwFQTBB4iTo5Oii5T4v6TQIsaD4358d9/H3XeAv15mqhkcA1TNMlKJuJDJrgqhVwTRh26MIywxU58TxSQ8x9c9fHy9i/Es73N/jh4lZzLAJxDPMt2wiDeIpzctnfM+cYQVJYX4nHjUoAsSP3JddvmNc8FhP8+MGOnUPHGEWCi0sdzGrGioxFPEUUXVKN+fcVnhvMVZLVdZ8578heGctrLMdZpDSGARSxAhQEYVJZRhIUarRoqJFO3HPfyDjl8kl0yuEhg5FlCBCsnxg//B727N/OSEmxSOAx0vtv0xDIR2gUbNtr+PbbtxAgSegSut5a/UgZlP0mstLXoE9G4DF9ctTd4DLneAgSddMiRHCtD05/PA+xl9UxbovwW61tzemvs4fQDS1FXyBjg4BEYKlL3u8e7O9t7+PdPs7wdVH3KbR7qlWwAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB+QEEg0eKkmzr7oAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAABxUlEQVR42u3bsWoUURyF8e9EsA0ItmkjphSsFAsrYUEEC0EEq4ASyBsIQp5BMY1g4QMIC1ZCGsUiIAQCVkKqtIFAwObajMNkUdJEcv/y/WCbne4c7szswgGVk79daK3dAVaN6ML8BHaS/DiztNbaM2ALuGJuXfgCPE/y7Y+ltdbeAU/MqTsnwL0kO6dKG07YK/Pp1gGwluR4aSjsEvDSXLq2ArwAWBq+uAlcNZfuPZiWtmIeZU7bWNqxeZRwNC1tzzxK2BtLS3IAzM2ke9uLr/yrwFdg2Wy69CHJ/entkSTfgdveKrs9YY/HrhavttYuAxvALeCGb5YXZnf4vP/9T4gkSZIkSZIkSZIkSZIk6Tw53+2X893CnO8W5Xy3KOe7BTnfLcr5btHT5ny3GOe7BTnfLcj5bjHOdwueMOe7BTjflSRJkiRJkiRJkiRJkqR/yvluv5zvFnbmfPct8NScunMCzJJ8OlVaa20deGM+3ToCriU5nM53t8yla8vAJjjfrebhtDRHFjU43y36M8D5bjG7Y2nDfPejmXTv9eIr/3XgM853ezVPMpveHkmyD9wF9s2nO9vAo7GrxavOd7t6fjnf/V/8AkkMlOopfThoAAAAAElFTkSuQmCC"
											class="menu-icon" alt="menu">
									</a>

								</div>
							</li>
						</ul>
					</div>
					<ul class="navbar-nav ml-auto">
							<li class="my-auto hand margin-5">
								<a href="./index.php?lang=en"><img src="./static/media/entranslation.png" alt="Use English" class="langImage"> </a>
							</li>
							<li class="my-auto hand">
								<a href="./index.php?lang=cn"><img src="./static/media/cntranslation.png" alt="使用中文" class="langImage"> </a>
							</li>
						</ul>
				</nav>
			</div>
		</div>

		<div class="container-fluid  stickyback">
			<div class="section main-section bottom-shadow row">
				<div class="no-padding col">
					<div class="d-md-block row">
						<div class="col">
							<div class="banner_area">
								<div class="lets-talk">
									<p><?php echo $phrases['talk_about_business'] ?></p>
								</div>
								<div class="banner">
									<img src="./static/media/mobile.fb8b964b.png" class="top-phone img-fluid" alt="hex mobile app">
								</div>
							</div>
						</div>
					</div>

					<div class="d-md-block inline-blocks">
						<div class="hb-left">
							<div class="hex-business">
								<img src="./static/media/hexbusinesstext.019a57c7.png"
								     class="hex-business-text img-fluid" alt="hexbusiness corporate logo">
							</div>
						</div>
						<div class="data">
							<div class="datarow">
								<div class="datacell stat-text">
									<div class="currLabel" lang="en">
										<strong>HEX</strong>/USD
									</div>
									<div class="currAmount">
										<strong><?php echo number_format($rateData['hexUsd'], 8) ?></strong>
									</div>

									<div class="currArrow">
										<?php
										if ($rateData['hexUsd24Change'] > 0)
										{
											echo '<img src="./static/media/upSmallGreenArrow.png" class="arrow" alt="positive arrow" />';
										}
										else
										{
											echo '<img src="./static/media/downSmallRedArrow.png" class="arrow" alt="negative arrow"  />';
										}
										?>
									</div>

									<div class="percent-text-<?php echo $rateData['hexUsd24Change'] >= 0 ? 'up' : 'down' ?> col-2 col">
										<?php echo $rateData['hexUsd24Change'] ?>%
									</div>
								</div>

								<div class="datacell stat-text">
									<div class="currLabel" lang="en">
										<strong>HEX</strong>/BTC
									</div>
									<div class="currAmount">
										<strong><?php echo floatval($rateData['hexBtc']) * 1E8 ?> sats </strong>
									</div>
									<div class="currArrow">
										<?php
										if ($rateData['hexBtc24Change'] > 0)
										{
											echo '<img src="./static/media/upSmallGreenArrow.png" class="arrow" alt="positive arrow" />';
										}
										else
										{
											echo '<img src="./static/media/downSmallRedArrow.png" class="arrow" alt="negative arrow"  />';
										}
										?>
									</div>
									<div class="percent-text-<?php echo $rateData['hexBtc24Change'] >= 0 ? 'up' : 'down' ?> col-2 col">
										<?php echo $rateData['hexBtc24Change'] ?>%
									</div>

								</div>

								<div class="datacell stat-text">
									<div class="currLabel" lang="en">
										<strong>HEX</strong>/ETH
									</div>
									<div class="currAmount">
										<strong><?php echo floatval($rateData['hexEth']) * 1E7 ?> gwei</strong>
									</div>
									<div class="currArrow">
										<?php
										if ($rateData['hexEth24Change'] > 0)
										{
											echo '<img src="./static/media/upSmallGreenArrow.png" class="arrow" alt="positive arrow" />';
										}
										else
										{
											echo '<img src="./static/media/downSmallRedArrow.png" class="arrow" alt="negative arrow"  />';
										}
										?>
									</div>
									<div class="percent-text-<?php echo $rateData['hexEth24Change'] >= 0 ? 'up' : 'down' ?> col-2 col">
										<?php echo $rateData['hexEth24Change'] ?>%
									</div>
								</div>

								<div class="datacell stat-text">
									<div class="currLabel" lang="en"><strong>BTC</strong>/USD</div>
									<div class="currAmount">
										<strong>$<?php echo round(floatval($rateData['btcUsd']) / 1000, 4) ?>
											k </strong></div>
									<div class="currArrow">
										<?php
										if ($rateData['btcUsd24Change'] > 0)
										{
											echo '<img src="./static/media/upSmallGreenArrow.png" class="arrow" alt="positive arrow" />';
										}
										else
										{
											echo '<img src="./static/media/downSmallRedArrow.png" class="arrow" alt="negative arrow"  />';
										}
										?>
									</div>
									<div class="percent-text-<?php echo $rateData['btcUsd24Change'] >= 0 ? 'up' : 'down' ?> col-2 col">
										<?php echo $rateData['btcUsd24Change'] ?>%
									</div>
								</div>
								<div class="datacell stat-text">
									<div class="currLabel" lang="en"><strong>ETH</strong>/USD</div>
									<div class="currAmount">
										<strong>$<?php echo $rateData['ethUsd'] ?></strong></div>
									<div class="currArrow">
										<?php
										if ($rateData['ethUsd24Change'] > 0)
										{
											echo '<img src="./static/media/upSmallGreenArrow.png" class="arrow" alt="positive arrow" />';
										}
										else
										{
											echo '<img src="./static/media/downSmallRedArrow.png" class="arrow" alt="negative arrow"  />';
										}
										?>
									</div>
									<div class="percent-text-<?php echo $rateData['ethUsd24Change'] >= 0 ? 'up' : 'down' ?> col-2 col">
										<?php echo $rateData['ethUsd24Change'] ?>%
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="d-md-block inline-tables">
						<div class="col-md-6 col-12">
							<div class="table-title stat-text table-margin row"><strong><?php echo $phrases['overview'] ?></strong></div>
							<div class="table-cell stat-text table-margin row">
								<div class="stat-cell col-4"><?php echo $phrases['total_supply'] ?></div>
								<div class="stat-cell col-3">
									<strong><?php echo round(floatval($rateData['hexTotalSupply']) / 1E9, 3) ?>
										B</strong></div>
								<div class="stat-cell col-3">
									$<?php echo number_format(floatval($rateData['hexTotalSupply'] * floatval($rateData['hexUsd'] / 1000)), 3) ?>
									k
								</div>
								<div class="stat-cell col-1"><?php
									if ($rateData['hexTotalSupply24Change'] > 0)
									{
										echo '<img src="./static/media/upSmallerGreenArrow.png" class="arrow" alt="positive arrow" />';
									}
									else
									{
										echo '<img src="./static/media/downSmallerRedArrow.png" class="arrow" alt="negative arrow"  />';
									}
									?></div>
								<div class="percent-text-<?php echo floatval($rateData['hexTotalSupply24Change']) >= 0 ? 'up' : 'down' ?> stat-cell my-auto col-1">
									<div class="small-percent"><?php echo $rateData['hexTotalSupply24Change'] ?>%</div>
								</div>
							</div>
							<div class="table-cell stat-text table-margin row">
								<div class="stat-cell col-4"><?php echo $phrases['number_of_locks'] ?></div>
								<div class="stat-cell col-3">
									<strong><?php echo round(floatval($rateData['hexLockedSupply']) / 1E9, 3) ?>
										B</strong></div>
								<div class="stat-cell col-3">
									$<?php echo number_format(floatval($rateData['hexLockedSupply'] * floatval($rateData['hexUsd'] / 1000)), 3) ?>
									k
								</div>
								<div class="stat-cell col-1"><?php
									if ($rateData['hexLockedSupply24Change'] > 0)
									{
										echo '<img src="./static/media/upSmallerGreenArrow.png" class="arrow" alt="positive arrow" />';
									}
									else
									{
										echo '<img src="./static/media/downSmallerRedArrow.png" class="arrow" alt="negative arrow"  />';
									}
									?></div>
								<div class="percent-text-<?php echo floatval($rateData['hexLockedSupply24Change']) >= 0 ? 'up' : 'down' ?> stat-cell my-auto col-1">
									<div class=" small-percent"><?php echo $rateData['hexLockedSupply24Change'] ?>%
									</div>
								</div>
							</div>
							<div class="table-cell stat-text table-margin row">
								<div class="stat-cell col-4"><?php echo $phrases['circulation_quantity'] ?></div>
								<div class="stat-cell col-3">
									<strong><?php echo round(floatval($rateData['hexCirculatingSupply']) / 1E9, 3) ?>
										B</strong></div>
								<div class="stat-cell col-3">
									$<?php echo number_format(floatval($rateData['hexCirculatingSupply']) * floatval($rateData['hexUsd'] / 1000), 3) ?>
									k
								</div>
								<div class="stat-cell col-1"><?php
									if ($rateData['hexCirculatingSupply24Change'] > 0)
									{
										echo '<img src="./static/media/upSmallerGreenArrow.png" class="arrow" alt="positive arrow" />';
									}
									else
									{
										echo '<img src="./static/media/downSmallerRedArrow.png" class="arrow" alt="negative arrow"  />';
									}
									?></div>
								<div class="percent-text-<?php echo floatval($rateData['hexCirculatingSupply24Change']) >= 0 ? 'up' : 'down' ?> stat-cell my-auto col-1">
									<div class=" small-percent"><?php echo $rateData['hexCirculatingSupply24Change'] ?>
										%
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-12">
							<div class="table-title stat-text row"><strong><?php echo $phrases['universal_amplifier'] ?></strong>
							</div>
							<div class="table-cell stat-text row">
								<div class="stat-cell col-4"><span lang="en"><?php echo $phrases['aa_pool_val'] ?></div>
								<div class="stat-cell col-6">
									<strong><?php echo number_format(floatval($rateData['adoptionAmplifierCurrentEth']) / 1000, 3) ?>
										k ETH </strong></div>
								<div class="stat-cell col-1"><?php
									if ($rateData['adoptionAmplifierCurrentEth24Change'] > 0)
									{
										echo '<img src="./static/media/upSmallerGreenArrow.png" class="arrow" alt="positive arrow" />';
									}
									else
									{
										echo '<img src="./static/media/downSmallerRedArrow.png" class="arrow" alt="negative arrow"  />';
									}
									?></div>
								<div class="percent-text-<?php echo $rateData['adoptionAmplifierCurrentEth24Change'] >= 0 ? 'up' : 'down' ?> stat-cell my-auto col-1">
									<div class=" small-percent"><?php echo $rateData['adoptionAmplifierCurrentEth24Change'] ?>
										%
									</div>
								</div>
							</div>
							<div class="table-cell stat-text row">
								<div class="stat-cell col-4"><?php echo $phrases['aa_pool_price'] ?></div>
								<div class="stat-cell col-6">
									<strong><?php echo number_format(floatval($rateData['adoptionAmplifierCurrentHexEth'] / 1000), 3) ?>
										k H/E </strong></div>
								<div class="stat-cell col-1"><?php
									if ($rateData['adoptionAmplifierCurrentHexEth24Change'] > 0)
									{
										echo '<img src="./static/media/upSmallerGreenArrow.png" class="arrow" alt="positive arrow" />';
									}
									else
									{
										echo '<img src="./static/media/downSmallerRedArrow.png" class="arrow" alt="negative arrow"  />';
									}
									?></div>
								<div class="percent-text-<?php echo $rateData['adoptionAmplifierCurrentHexEth24Change'] >= 0 ? 'up' : 'down' ?> stat-cell my-auto col-1">
									<div class="small-percent"><?php echo $rateData['adoptionAmplifierCurrentHexEth24Change'] ?>
										%
									</div>
								</div>
							</div>
							<div class="table-cell stat-text row">
								<div class="stat-cell col-4"><?php echo $phrases['uniswap_price'] ?></div>
								<div class="stat-cell col-6">
									<strong><?php echo round(floatval($rateData['uniswapHexEth']) / 1000, 3) ?> k
										H/E </strong></div>
								<div class="stat-cell col-1"><?php
									if ($rateData['uniswapHexEth24Change'] > 0)
									{
										echo '<img src="./static/media/upSmallerGreenArrow.png" class="arrow" alt="positive arrow" />';
									}
									else
									{
										echo '<img src="./static/media/downSmallerRedArrow.png" class="arrow" alt="negative arrow"  />';
									}
									?></div>
								<div class="percent-text-<?php echo $rateData['uniswapHexEth24Change'] >= 0 ? 'up' : 'down' ?> stat-cell my-auto col-1">
									<div class="small-percent"><?php echo $rateData['uniswapHexEth24Change'] ?>%</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="section bottom-shadow row"><a name="hexmobile"></a>
				<div class="col">
					<div class="justify-content-center order-sm-1 row">
						<div class="col-md-2 col-4">
							<img src="data:image/png;base64,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" class="section-icon img-fluid" alt="hex mobile app logo" />
						</div>
					</div>
					<div class="justify-content-center">
						<p class="title"><?php echo $phrases['click_link_below_to_download_app'] ?></p>
					</div>
					<div class="d-flex flex-wrap no-padding justify-content-center">
						<div class="col-sm-6 col-12 mobile-screens"><img src="./static/media/hex-mobie-assetsl.7c611557.png" class="mobile-image" alt="hex mobile app on smart phones">
						</div>
						<div class="download-buttons col-sm-4 col-12">
							<div class="download row">
								<a href="https://hexbusiness.net/APK/hexmobileAndroid.apk"><img src="./static/media/apk.d5bffc48.png" class="download-button" alt="download hex mobile app APK"></a>
							</div>
							<div class="download row">
								<a href="https://play.google.com/store/apps/details?id=com.hexbusiness.hexmobile">
									<img src="./static/media/gpbutton.png" class="download-button" alt="download hex mobile on Google Play">
								</a>
							</div>
							<div class="download row">
								<a>
									<img src="./static/media/ios.4d7f4e71.png" class="download-button" alt="download for iOS coming soon">
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section bottom-shadow row"><a name="hexcredit"></a>
				<div class="col">
					<div class="row">
						<div class="col">
							<div class="justify-content-center row">
								<div class="col-md-2 col-4">
									<img src="./static/media/HEXCredit.f7a7e4b9.png" class="section-icon img-fluid" alt="hex credit logo">
								</div>
							</div>
							<p class="title"><strong>hex.business</strong> <?php echo $phrases['decentralized_credit_platform'] ?></p>
							<div class="justify-content-center row">
								<img src="./static/media/creditcards.53d7f34f.png" class="credit-cards" alt="hex on cards">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section bottom-shadow row">
				<a name="hexmoney"></a>
				<div class="col">
					<div class="justify-content-center row">
						<div class="col-md-2 col-4">
							<img src="./static/media/HEXMoney.8a7b779a.png" class="section-icon img-fluid" alt="hex money" />
						</div>
					</div>
					<div class="justify-content-center row">
						<div class="col-12">
							<p class="title"><?php echo $phrases['transform_hex_to_hex_money']; ?></p>
						</div>
					</div>
					<div class="justify-content-center row">
						<div class="col-9">
							<div class="justify-content-center mb-5 mt-5 d-flex flex-wrap">
								<div class="my-auto money-col money-text col-md-auto col-12"><strong><?php echo $phrases['send'] ?></strong></div> 
								<div class="my-auto money-col col">
									<input type="number" pattern="\d*" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeydown="javascript: return event.keyCode == 69 || event.keyCode == 189 || event.keyCode == 187 ? false : true"  maxLength="12" disabled="disabled" class="enter-amount" id='enter-amount' min="0" placeholder="<?php echo $phrases['enter_amount'] ?>" />
								</div>
 
								<div class="my-auto money-text money-col col">
									<strong lang="en">HEX</strong>
								</div>
								<div class="my-auto money-col money-text col-sm-auto">
									<strong><?php echo $phrases['can_receive'] ?> <span lang="en" id="canreceive">0 HXY&#46;</span></strong>
								</div>
								<div class="my-auto money-col col-sm-auto">
									<button type="button" class="action-button btn btn-light" id='transform'><?php echo $phrases['convert'] ?></button>
								</div>
							</div>
							<div class="justify-content-center mb-5 d-flex flex-wrap">
								<div class="my-auto money-text money-col col-md-auto col-12"><strong><?php echo $phrases['i_want'] ?></strong></div>
								<div class="my-auto money-col col">
									<div role="group" class="w-100 btn-group btn-group-toggle">
										<label class="my-auto select-button btn active btn-light" id='freeze'>
											<input name="freeze-unfreeze" type="radio" autocomplete="off" value="0" checked=""><?php echo $phrases['freeze'] ?></label>
											<label class="my-auto select-button btn btn-light" id='unfreeze'>
												<input name="freeze-unfreeze" type="radio" autocomplete="off" value="1"><?php echo $phrases['thaw'] ?>
											</label>
									</div>
								</div>

 
								<div class="my-auto money-col col"><input type="number" class="enter-amount" pattern="\d*"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeydown="javascript: return event.keyCode == 69 || event.keyCode == 189 || event.keyCode == 187 ? false : true"  maxLength="12" disabled='disabled' id='freeze-amount' placeholder="<?php echo $phrases['enter_amount'] ?>" /></div>
 
								<div class="my-auto money-col money-text col"><strong lang="en">HXY&#46;</strong></div>

								<div class="my-auto money-col col">
									<button type="button" class="action-button btn btn-light" id='proceed'><?php echo $phrases['proceed'] ?></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row"><p class="mb-5 title"><strong><?php echo $phrases['your_wallet_balance'] ?>&nbsp;&#58;&nbsp; <span lang="en" id='balance'>0 HXY</span> </strong></p>
					</div>
					<div class="d-flex flex-wrap stat-text no-padding">
						<div class="no-padding col-md-6 col-12">
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['total_supply'] ?></div>
								<div class="col-6"><strong lang="en" id="total_supply">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['hxy_amount_frozen'] ?></div>
								<div class="col-6"><strong lang="en" id="frzoneTokenBalance">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['current_supply'] ?></div>
								<div class="col-6"><strong lang="en" id="calculating_supply">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['approved_amount'] ?></div>
								<div class="col-6"><strong lang="en" id="approved_amount">0 HEX</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['total_airdrop_amount'] ?></div>
								<div class="col-6"><strong lang="en" id="total_approved">0 HEX</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['total_hxy_conversion'] ?></div>
								<div class="col-6"><strong id="total_hxy_conversion">0 HXY</strong></div>
							</div>
						</div>
						<div class="no-padding col-md-6 col-12">
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['hxy_locked'] ?></div>
								<div class="col-6"><strong lang="en" id="locked_tokens">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['your_hxy_interest'] ?></div>
								<div class="col-6"><strong lang="en" id="interest">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['your_frozen_hxy'] ?></div>
								<div class="col-6"><strong id="tokenFrozenBalances">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['maximum_supply'] ?></div>
								<div class="col-6"><strong lang="en" id="maxSupply">0 HXY</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['Your_airdropped_dividends'] ?></div>
								<div class="col-6"><strong lang="en" id="your_airdropped_divs">0 HEX</strong></div>
							</div>
							<div class="table-cell stat-text stat-cell row">
								<div class="col-6"><?php echo $phrases['total_hex_conversion'] ?></div>
								<div class="col-6"><strong id="total_hex_conversion">0 HEX</strong></div>
							</div>
						</div>
					</div>
					<p class="referral-text"><?php echo $phrases['referral_link'] ?>&nbsp;&#58;&nbsp;<span id="referal_url"></span> <br></p></div>
			</div>
			<div class=" bottom-shadow row">
				<div class="col">
					<div class="justify-content-center row">
						<div class="col-10"><p class="project-title title"><?php echo $phrases['refer_to_other'] ?></p></div>
					</div>
					<div class="project-icons justify-content-center d-flex flex-wrap">
						<div class="col-md-2 col-sm-2 col-4"><img src="./static/media/HEXRocket.23bb336d.png"
						                                          class="project-image" alt="hex business rocket logo">
						</div>
						<div class="col-md-2 col-sm-2 col-4"><img src="./static/media/HEXStake.2602e5b3.png"
						                                          class="project-image" alt="hex business stake logo">
						</div>
						<div class="col-md-2 col-sm-2 col-4"><img src="./static/media/HEXbet.0396ba58.png"
						                                          class="project-image" alt="hex business bet logo">
						</div>
						<div class="col-md-2 col-sm-2 col-4"><img src="./static/media/HEXStable.2affd553.png"
						                                          class="project-image" alt="hex business stable logo">
						</div>
						<div class="col-md-2 col-sm-2 col-4"><img src="./static/media/HEXpool.8cbeea9c.png"
						                                          class="project-image" alt="hex business pool logo">
						</div>
					</div>
					<div class="row">
						<div tabindex="0" class="gallery autoplay items-8">
							<div id="no-autoplay-1" class="control-operator"></div>
							<div id="no-autoplay-2" class="control-operator"></div>
							<div id="no-autoplay-3" class="control-operator"></div>
							<div id="no-autoplay-4" class="control-operator"></div>
							<div id="no-autoplay-5" class="control-operator"></div>
							<div id="no-autoplay-6" class="control-operator"></div>
							<div id="no-autoplay-7" class="control-operator"></div>
							<figure class="item">
								<img class="slider_img" src="./static/media/hex-credit-update_1524.jpg"/>
							</figure>
							<figure class="item">
								<img class="slider_img" src="./static/media/Hex-Mobile-update_1524.jpg"/>
							</figure>
							<figure class="item">
								<img class="slider_img" src="./static/media/Hex-money-updated_1524.jpg"/>
							</figure>
							<figure class="item">
								<img class="slider_img" src="./static/media/hexmoneypromo_1524.jpg"/>
							</figure>

							<figure class="item">
								<img class="slider_img" src="./static/media/comingsoon-hexmobile_1524.jpg"/>
							</figure>
							<figure class="item">
								<img class="slider_img" src="./static/media/HEXsplash_1524.jpg"/>
							</figure>
							<figure class="item">
								<img class="slider_img" src="./static/media/3HEXBanner_1524.jpg"/>
							</figure>
							<div class="controls">
								<a href="#no-autoplay-1" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
								<a href="#no-autoplay-2" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
								<a href="#no-autoplay-3" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
								<a href="#no-autoplay-4" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
								<a href="#no-autoplay-5" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
								<a href="#no-autoplay-6" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
								<a href="#no-autoplay-7" class="control-button"><div class="slider-dot"><img src="./static/media/white-dot-png.png" /></div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section bottom-shadow row"><a name="hexplay"></a>
			<div class="col">
				<div class="justify-content-center row">
					<div class="col-md-2 col-4"><img src="./static/media/HEXPlay.502fd8be.png"
					                                 class="section-icon img-fluid" alt="hex business play logo">
					</div>
				</div>
				<div class="row"><p class="title"> <?php echo $phrases['on'] ?>  <strong lang="en">HEX</strong></p></div>

				<div class="justify-content-center row" style="height:auto">
					<iframe allowfullscreen="1"
					        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
					        title="YouTube video player"
					        src="https://www.youtube.com/embed/qFdVVCw1AW0?autoplay=0&amp;mute=0&amp;controls=0&amp;origin=https%3A%2F%2Fhexbusiness.net&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;iv_load_policy=3&amp;modestbranding=1&amp;enablejsapi=1&amp;widgetid=1"
					        id="widget2" class="youtubeEmbed" frameborder="0"></iframe>

				</div>
				<noscript>
					<a href="https://youtube.com/qFdVVCw1AW0"><span lang="en">Richard Heart speaking on :Pumpamentals. How HEX's design creates value quickly. Speculative stickiness & secret sauce.</a>
				</noscript>
			</div>
		</div>


		<div class="section bottom-shadow row">
			<div class="col">
				<div class="row"><p class="title"> <?php echo $phrases['for_more_information_subscribe'] ?></p></div>
				<div class="justify-content-center emailform">
					<form action="./includes/handlesubscription.php?lang=<?php echo $language?>" method="post" id="emailForm">
						<div ><input class="email-input" type="email" oninput="removeSpaces(this.value)"  name="email" placeholder="<?php echo $phrases['email'] ?>" maxlength="50" id="email" ></div>
						<div class="sign-up">
							<button type="submit" class="sign-up btn btn-light"><strong><?php echo $phrases['subscription'] ?></strong></button>
							<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
						</div>

					</form>
				</div>
				<div class="justify-content-center row">
					<div class="col-md-1 col-sm-2 col-4">
						<a href="https://t.me/hexmobileapp">
							<img src="data:image/png;base64,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"
							class="w-75">
						</a>
					</div>
					<div class="col-md-1 col-sm-2 col-4">
						<a href="https://twitter.com/HexBusiness/">
							<img src="data:image/png;base64,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"
							class="w-75">
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="section bottom-shadow row hidden">
			<div class="col">
				<div class="justify-content-center row">
					<p> <?php echo $phrases['welcome_donations_to'] ?>: 0x1EF0Bab01329a6CE39e92eA6B88828430B1Cd91f </p>
				</div>
				<div class="justify-content-center row">
					<div class="col-md-2 col-sm-5 col-6">
						<img src="./static/media/hexbusinessqrcode.8f0141ec.jpg" class="img-fluid" alt="donate to this project">
					</div>
				</div>
			</div>
		</div>
		<br/>
		<p> <?php echo $phrases['beta_use_at_your_risk'] ?> </p>

		<footer>
		  <p class="footerDisclaimer"><span><?php echo $phrases['copy_right'] ?></span>
		<br/>
		<a href="http://hexbusiness.net/privacypolicy.html" target="_blank" rel="noopener noreferrer" class="footerDisclaimer"><?php echo $phrases['privacypolicy'] ?></a>
		<br/>
		<br/>
		<span id="donate" class="hidden">Donations are welcome &#58; <br/>0x1EF0Bab01329a6CE39e92eA6B88828430B1Cd91f</span></p>
		</footer>
	</div>
</div>
<div style="display: none;width:100vw;height:100vh;position:fixed;top:0;left:0;background-color: black" class="" id='modal-back'>
	</div>
<div class='modal-dialog' id="modal" style='display: none'>
 
	<div class="modal-content">
		<div class="modal-header">
			<div class="modal-title h4">
				<strong><?php echo $phrases['approve_token'] ?></strong>
			</div>
			<button type="button" class="close"><span aria-hidden="true" id='modal_close'>×</span><span class="sr-only">Close</span></button>
		</div>
		<div class="modal-body">
			<div class="justify-content-center row mobile-approvemodal">
				<div class="col-md-4">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAGECAMAAAC77O3EAAAC+lBMVEUAAAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////86i/ucAAAA/XRSTlMAAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gIiMkJSYnKCkqKywtLi8wMTIzNDU2Nzg5Ojs8PT4/QEFCQ0RFRkdISUpLTE1OT1BRUlNU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" class="img-fluid">
				</div>
				<div class='mobile-approvediv'>
					<div class="my-auto ">
						<input type="number" class="enter-amount" onkeydown="javascript: return event.keyCode == 69 || event.keyCode == 189 || event.keyCode == 187 ? false : true"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxLength="12" disabled='disabled' id='modal-amount' placeholder="<?php echo $phrases['enter_amount'] ?>" />
					</div>
					<div class="my-auto col-md-auto">
						<strong>HEX</strong>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" id="btn_approve" class="action-button btn btn-light"><?php echo $phrases['approve'] ?></button>
		</div>
	</div>
</div>

<script>
	var no_metamask = "<?php echo $phrases['no_metamask'] ?>";
	var no_input = "<?php echo $phrases['no_input'] ?>";
	var in_processing = "<?php echo $phrases['in_processing'] ?>";
	var entered_invalid_email = "<?php echo $phrases['entered_invalid_email'] ?>";
</script>

<script src="https://unpkg.com/web3@latest/dist/web3.min.js"></script>
<script src="./static/extensions/sweetalert/sweetalert.min.js"></script>
<script src="./static/js/actions/contractABI.js"></script>
<script src="./static/js/actions/action.js"></script>
<script src="./static/js/pages/index.js"></script> 
</body>


</html>
