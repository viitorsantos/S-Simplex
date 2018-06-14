<?php
session_start();
require_once('view/conteudo.php');


class restricoes
{
	
	public function __construct() {
		
		//é criado dinimicamente os campos para preennche-los
		if (isset($_REQUEST['qtdevariaveis']) and isset($_REQUEST['qtderestricoes']) and isset($_REQUEST['objetivo']))
		{
			$_SESSION['qtdevariaveis'] = $_REQUEST['qtdevariaveis'];
			$_SESSION['qtderestricoes'] = $_REQUEST['qtderestricoes'];
			$_SESSION['objetivo'] = $_REQUEST['objetivo'];
		}
		
		$conteudo.='<h1>Função Objetiva</h1>';
		
		//Monta Z = .......
		$conteudo.='<form name="frmdefinicao" method="GET" action="?pag=formapadrao.php"><input type="hidden" name="pag" value="formapadrao" > ';
		if ($_SESSION['objetivo']=='max')
		{
			$conteudo.='<strong>Maximizar  Z =  </strong>';
		}else{
			$conteudo.='<strong>Minimizar  Z =  </strong>';
		}
		
		$conteudo.='<div class="container padding5">';
		for ($i=1; $i <= $_SESSION['qtdevariaveis']; $i++)
		{ 
			$conteudo.='<input type="number" step="1" class="style-input" name="z'.$i.'" size="3" maxlength="4"> X<sub>'.$i.'</sub>';
			if($i<$_SESSION['qtdevariaveis'])
			{
				$conteudo.=' + ';
			}
		}
		$conteudo.='</div>';
		
		//Monta requisicoes
		$conteudo.='<h2>Restrições</h2>';
		
		//L de linha   C de coluna
		for ($l=1; $l <= $_SESSION['qtderestricoes']; $l++)
		{ 
			$conteudo.='<div class="container padding5">';
			for ($c=1; $c <= $_SESSION['qtdevariaveis'] ; $c++)
			{ 
				
				$conteudo.='<input type="number" step="1" class="style-input" name="r'.$l.'_'.$c.'" size="3" maxlength="4"> X<sub>'.$c.'</sub>';
				if($c<$_SESSION['qtdevariaveis'])
				{ 
					// se nao for a ultima coloca um ponto
					$conteudo.=' + ';
				}else{
					//se não acrescenta o resultado da linha
					$conteudo.='
						<span id="relacao" name="relacao'.$l.'"><=</span>
						<input type="number" class="style-input" step"1" name="resultado'.$l.'" size="3" maxlength="4">
					';
				}
			}
			$conteudo.='</div>';
		}
		
		//mostra x1,x2...xx>=0
		$funcao='';
		for ($c=1; $c <=$_SESSION['qtdevariaveis']; $c++)
		{ 
			$funcao=$funcao.'X<sub>'.$c.'</sub>';
			if($c<$_SESSION['qtdevariaveis'] )
			{
				$funcao=$funcao.' , ';	
			}else{
				$funcao=$funcao.' >= 0;';
			}
		}
		$conteudo.='</div>';
		
		$_SESSION['restricaopadrao']=$funcao;
		$conteudo.=$funcao;
		$conteudo.='<br><br>';
		$conteudo.='<button id="submit" name="submit" class="btn btn-next btn-next-green">Próximo</button>';
		$conteudo.='</form>';
		$this->SetConteudo($conteudo);
		
	}
	public function SetConteudo($c)
	{
		$this->conteudo = $c;
	}
	public function GetConteudo()
	{
		return $this->conteudo ;
	}
}