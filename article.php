<html>
<head>
	<title>Naujienos</title>
	<link rel="stylesheet" href="article.css" media="screen"/>
</head>

<?php 
	include("db.php");
?>
<body>
<center>	
	<?php
	
		$sql="SELECT * FROM news";
		$exec=mysql_query($sql);
		
		while($article=mysql_fetch_array($exec))
			{
				?>
				<div class="news">
				<h1><?php echo $article['Title'];?></h1>
				<?php echo $article['Content'];?>
				<label><?php echo $article['Date'];?></label>
				</div>
				<?php
			}
	
	?>		
		
	</form>
</center>
</body>
</html>