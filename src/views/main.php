<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if($_SESSION['game_in_progress']){ ?>
				<div class="alert alert-success" role="alert">
					<p>Turn <?php echo $_SESSION['turn'] - 1  ?> summary: </p>
					<p><?php echo $_SESSION['message'] ?></p>
				</div>
				<?php }else{ ?>
				<div class="alert alert-info" role="alert">
					<p><?php echo $_SESSION['message'] ?></p>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">Hero</div>
					<div class="panel-body">
						<table class="table">
							<?php foreach($_SESSION['hero']->getStats() as $stat => $value){ ?>
							<tr>
								<td><?php echo $stat; ?></td>
								<td><?php echo $value; ?></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-danger">
					<div class="panel-heading">Beast</div>
					<div class="panel-body">
						<table class="table">
							<?php foreach($_SESSION['beast']->getStats() as $stat => $value){ ?>
							<tr>
								<td><?php echo $stat; ?></td>
								<td><?php echo $value; ?></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 col-md-offset-5">
				<form action="" method="<?php echo ($_SESSION['game_in_progress']) ? 'GET' : 'POST' ?>">
					<button type="submit"class="btn btn-primary btn-lg">
						<?php echo ($_SESSION['game_in_progress'])
								? 'Turn ' . $_SESSION['turn']
								: 'Start new game'; 
						?>
					</button>
				</form>
				
			</div>
		</div>
	</div>
</body>
</html>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>