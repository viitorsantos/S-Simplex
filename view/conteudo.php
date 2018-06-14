<?php  

// Aqui nós configuramos os SET e GET. 
// Fazemos a chamada para o Bootstrap

class conteudo
{
	public $title;
	public $content;
	public $projectName;
	public $table;
	public function __construct($title,$projectName) {
		$this->SetTitle($title);
		$this->SetProjectName($projectName);
	}
	
	public function SetTitle($t)
	{
		$this->title = $t;
	}

	public function GetTitle()
	{
		return $this->title;
	}

	public function SetContent($c)
	{
		$this->content = $c;
	}

	public function GetContent()
	{
		return $this->content;
	}

	public function SetProjectName($p)
	{
		$this->projectName = $p;
	}

    public function GetProjectName()
    {
		return $this->projectName;
	}

	public function ShowTemplate()
	{
	  ?>
			<!DOCTYPE html>
			<html lang="pt-br">
				<head>
			    	<meta charset="utf-8">
				    <meta http-equiv="X-UA-Compatible" content="IE=edge">
			    	<meta name="viewport" content="width=device-width, initial-scale=1">
			 	   	<title><?=$this->GetTitle()?></title>
						<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i" rel="stylesheet"> 
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
						<link rel="stylesheet" href="css/estilo.css">
				</head>

			  	<body style="width:100%;">
			  		<!--menu-->
					<div class="container text-center topo">
						<h1><?=$this->GetProjectName()?></h1>
                    </div>    
					<!--menu-->
					<div class="container">
			    		<div class="row">
			    			<div class="center">
			   					<?=$this->GetContent()?>
			  				</div>
			    		</div><!--row-->
					</div><!--container theme-showcase-->
                    <?php
					if($_REQUEST['pag']=='resultado'){
					?>
                    <?php
					}
					?>
				
				<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>	
				</body>
			</html>
	  	<?php
	}
}
?>