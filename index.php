<?php
	include ('controllers/IndexController.php');
	use \controllers\IndexController;

	$controller = new IndexController();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
</head>
<body>
	<?php $controller->renderView('index'); ?>

	<script>
		var encryptedData1 = '<?php echo $controller->getExampleEncrypted1(); ?>';
		var encryptedData2 = '<?php echo $controller->getExampleEncrypted2(); ?>';
	</script >
	<script src="js/lib/crypto-js-3.1.2.js"></script>
	<script src="js/crypto.js"></script>
</body>
</html>