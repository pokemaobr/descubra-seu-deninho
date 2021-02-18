<?php

session_start();

function shuffle_assoc(&$array) {
    $keys = array_keys($array);

    shuffle($keys);

    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }

    $array = $new;

    return true;
}

$deninhos = [
    1 => 'deninho vampiro',
    2 => 'deninho dourado',
    3 => 'deninho ano novo',
    4 => 'deninho carnavalesco',
    5 => 'deninho noel',
    6 => 'deninho padrao',
    7 => 'deninho caipira',
];

$imagens = [
    1 => 'pic.twitter.com/LtyB4Xiebh',
    2 => 'pic.twitter.com/nBr4suxC1P',
    3 => 'pic.twitter.com/YmU2Q3BHwM',
    4 => 'pic.twitter.com/X6KFLlA2d3',
    5 => 'pic.twitter.com/DWaC7x5XaR',
    6 => 'pic.twitter.com/Pssh4S50zr',
    7 => 'pic.twitter.com/QkBO9gmA0r',
];

$jsonPerguntas = file_get_contents('../perguntas.json');
$perguntas = json_decode($jsonPerguntas,true);

$finalizou = false;

if (!empty($_SESSION['pergunta'])) {

    if (!empty($_POST['resposta'])) {
        $_SESSION['pergunta']++;
        $_SESSION['respostas'][] = $_POST['resposta'];
    }

    if ($_SESSION['pergunta'] > count($perguntas)) {
        session_destroy();
        $values = array_count_values($_SESSION['respostas']);
        $mode = array_search(max($values), $values);
        $indice = 'Qual Deninho você é?';
        $pergunta['pergunta'] = ucwords($deninhos[$mode]);
        $finalizou = true;
        $url = urlencode("
Eu me identifico com o " . ucwords($deninhos[$mode]) . "

Descubra com qual deninho você se identifica:
Qual é o seu Deninho - https://deninho.pokemaobr.dev - via @pokemaobr ". $imagens[$mode]);
        $url = "https://twitter.com/intent/tweet?text=" . $url;

    } else {

        $chave = $_SESSION['pergunta'];
        $pergunta = $perguntas[$chave-1];
        $indice = 'Pergunta ' . $chave;
        shuffle_assoc($pergunta['respostas']);

    }


} else {

    $chave = 1;
    $pergunta = $perguntas[0];
    $respostas = [];
    $_SESSION['pergunta'] = 1;
    $indice = 'Pergunta 1';
    shuffle_assoc($pergunta['respostas']);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Qual Deninho Você é?</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($finalizou) { ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="deninho.pokemaobr.dev">
    <meta name="twitter:title" content="<?= ucwords($deninhos[$mode]) ?>">
    <meta name="twitter:description" content="Site para você saber qual deninho você mais se identifica">
    <meta name="twitter:creator" content="pokemaobr">
    <meta name="twitter:image" content="https://deninho.pokemaobr.dev/images/deninhos/<?= str_replace(' ','-',$deninhos[$mode]) ?>.png">
    <meta name="twitter:domain" content="pokemaobr.dev">
    <?php } ?>

    <!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">

		<div class="wrap-contact100">
			<div class="contact100-form-title" style="background-image: url(images/bg-01.jpg);">
				<span class="contact100-form-title-1">
					 <?= $indice ?>
				</span>

				<span class="contact100-form-title-2">
					<?= $pergunta['pergunta'] ?>
				</span>

			</div>

			<form class="contact100-form validate-form" method="POST">

                <?php if (!empty($pergunta['respostas'])) {
                    foreach ($pergunta['respostas'] as $indice => $resposta) { ?>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn" name="resposta" value="<?= $indice ?>">
						<span>
							<?= $resposta ?>
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
                <?php }
                }
                ?>
                <?php if ($finalizou) { ?>
                    <img src="images/deninhos/<?= str_replace(' ','-',$deninhos[$mode]) ?>.png" />
                <a href="<?= $url ?>" id="twitter-share-btt" rel="nofollow" target="_blank" class="twitter-share-button contact2-form-btn" style="text-decoration: none;">
                    Compartilhar no Twitter
                </a>
                    <a href="https://twitch.tv/pokemaobr" id="twitter-share-btt" rel="nofollow" target="_blank" class="twitter-share-button contact2-form-btn" style="text-decoration: none;">
                        Live do Pokemaobr
                    </a>
                <?php } ?>
			</form>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="js/map-custom.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L0S5KLL3K3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-L0S5KLL3K3');
    </script>

</body>
</html>
