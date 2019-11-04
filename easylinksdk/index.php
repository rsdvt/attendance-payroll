
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include 'koneksidb.php';
    ?>
    <title>Client Easylink SDK</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link type="image/gif" href="images/favicon.gif" rel="icon">
</head>
<body>

<script type="text/javascript">
    $(function(){
        $('form').on('submit', function(e) {
            $(this).before("<center><img src='images/hourglass.gif' alt='loading' /></center>").fadeOut();
        });
    });
</script>

    <div id="wrapper">
	
		<form method="post">
			<div id="sidebar-wrapper">
			   <ul class="sidebar-nav">
			   
					<li class="sidebar-brand"><a href="index.php?m=content&p=home">EasyLink SDK</a></li>
					
					<li><a href="index.php?m=content&p=user" >Data User</a></li>
					<li><a href="index.php?m=content&p=scanlog" >Data Scanlog</a></li>
					<li><a href="index.php?m=content&p=info" >Info</a></li>
					<li><a href="index.php?m=content&p=settings" >Settings</a></li>
					<li><a href="index.php?m=content&p=auto" >Auto</a></li>
				</ul>
			</div>
		</form>
		
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><span class="glyphicon glyphicon glyphicon-resize-full"></span></button></a>
						<br>
						<br>
                        <div class="panel-group">
                            <div class="panel panel-default">
							
								<?php
								if (($_GET['p'])!=='auto') {
								?>
									<div class="panel-heading">
									<?php 
									echo '
									<h3>Device</h3>
									<table class="table table-condensed">
										<tr>
											<th>Server IP</th>
											<th>Server Port</th>
											<th>Device SN</th>
											<th></th>
										</tr>
										<tr>';
											$tampil = "SELECT * FROM tb_device";
											$sql = mysql_query($tampil);
											while($data = mysql_fetch_array($sql)) {
												echo "
												<td>".$data[server_IP]."</td>
												<td>".$data[server_port]."</td>
												<td>".$data[device_sn]."</td>";?>
												<td><a href="content/action.php?id=<?php echo $data['No'];?>" onclick="return confirm('delete this record ?');"><input class="btn btn-default" type="submit" value="delete"></a></td>
										</tr>
									<?php 
											} 
									}
										echo '</table>'; 
										
									?>
									
								</div>
								
								
								<div class="panel-body">
									<?php
									if (!isset($_GET['p'])) {
										include ('content/home.php');
									} else {
										$page = $_GET['p'];
										$modul = $_GET['m'];
										include $modul . '/' . $page . ".php"; 
									} ?>
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script> $("#menu-toggle").click(function(e) { e.preventDefault(); $("#wrapper").toggleClass("toggled"); }); </script>
</body>
</html>