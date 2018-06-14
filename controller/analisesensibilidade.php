<?php
require_once('simplex.php');


class analisesensibilidade
{
	
	public function __construct() {
		$simplex = new Simplex;
		
		//$conteudo='';
		session_start();
		$tabelafinalinicial = array();
		$tabelafinalfinal = array();
		$qtdelinhas = $_SESSION['qtdelinhas'];
		$qtdecolunas = $_SESSION['qtdecolunas'];
		$tabelainicial = $_SESSION['tabelainicial'];
		$tabelafinal = $_SESSION['tabelafinal'];
		
		$conteudo.='<h1 style="text-align:center;" ><strong> Análise de Sensibilidade</strong></h1><br>';
		$conteudo.='<h3><strong>Tabela Inicial</strong></h1><br>';
		
		//define qual tabela vai ser impressa
		$simplex->SetTabela($tabelainicial);
		
		//imprimi
		$conteudo.=$simplex->MostraTabela('12',$qtdecolunas,$qtdelinhas);
		$conteudo.='<h3><strong>Tabela Final</strong></h1><br>';
		$simplex->SetTabela($tabelafinal);
		$conteudo.=$simplex->MostraTabela('12',$qtdecolunas,$qtdelinhas);  
		$conteudo.='<h3><strong>Qual a interpretação do quadro final?</strong></h1><br>';
		$conteudo.='<div class="col-lg-6"><h4>Variáveis Básicas</h4>';
		
		for ($linha=1; $linha < $_SESSION['qtdelinhas'] ; $linha++)
		{
		  if ((substr(strtoupper(trim($tabelafinal[$linha][0])),0,1)=='F'))
		  {
			$conteudo.='<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'  ->     indica sobra/falta (se resultado negativo) de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades do recurso R'.$linha.' e a ultilização de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades.</p>';
		  }
		  else{
			if((substr(strtoupper(trim($tabelafinal[$linha][0])),0,1)!='Z'))
			{
			  $conteudo.='<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'  ->     indica produção de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades do produto  P'.$linha.'.</p>';
			}
			}
		}
		
		$conteudo.='</div>';
		$conteudo.='<div class="col-lg-6"><h4>Variáveis Não-Básicas</h4>';
			  
				
		$basicas=null;
		$aux=0;
		for ($i=1; $i < $qtdelinhas ; $i++)
		{
		  $basicas[$aux]=$tabelafinal[$i][0];
			$aux++;
		}
		
		for ($i=1; $i < $qtdecolunas-1; $i++)
		{
		  $contador=0;
		  $Variavel;
		  for ($y=1; $y < $qtdelinhas ; $y++)
		  {
			if($tabelafinal[0][$i]==$tabelafinal[$y][0])
			{
			  $contador++;
			}     			
		  }
		  if($contador==0)
		  {
			$conteudo.='<p>'.$tabelafinal[0][$i].' = 0     ->    indica sobra/falta de 0 unidades do recurso R'.substr($tabelafinal[0][$i],6,1).' que significa a utilização total dos recursos.</p><br>';
		  }
		}
		
		$conteudo.='</div>';
		$conteudo.='<h3><strong>Preço Sombra</strong></h1><br>';
		$conteudo.='<p>O preço sombra é a taxa de variáção da função objetiva (Z) para uma alteração a disponibilidade de recursos.</p>';
		$conteudo.='<p><strong>Isto é :</strong> refere-se a quantidade que o lucro total (Z) poderia ser melhorado caso a quantidade do recurso seja igual a 1</p><br><br>';
		
		$tabelaprecosombra=array();
		$aux=0;
		
		//preenche as 2 primeiras colunas da tabela preço sombra
		$recursos=array();
		$resultadorecurso=array();
		for ($coluna=0; $coluna < $qtdecolunas ; $coluna++)
		{ 
		  if(trim(strtoupper(substr($tabelafinal[0][$coluna],0,1)))=='F')
		  {
			$tabelaprecosombra[$aux][0]=$tabelafinal[0][$coluna];
			array_push($recursos, $tabelafinal[0][$coluna]);
			$tabelaprecosombra[$aux][1]=$tabelafinal[$_SESSION['qtdelinhas']-1][$coluna];
			array_push($resultadorecurso, $tabelafinal[$_SESSION['qtdelinhas']-1][$coluna]);
			$aux++;
		  }
		}
		
		$deltas = array();
		$lmin = array();
		$lmax = array();
		$minima=999999999;
		$maxima=-999999999;
		$aux = 0;
		$aux2= 1;
		
		//calculando  o limite minimo e maximo
		for ($coluna=($_SESSION['qtdevariaveis']+1); $coluna < ($_SESSION['qtdecolunas']-1) ; $coluna++)
		{
		  $minima=9999999;
		  $maxima=-9999999;
		  for ($linha=1; $linha < ($_SESSION['qtdelinhas']-1); $linha++)
		  {
			$b = ($tabelafinal[$linha][$_SESSION['qtdecolunas']-1]);
			$f =  ($tabelafinal[$linha][$coluna]);       
			$vlrb = $tabelainicial[$aux2][$_SESSION['qtdecolunas']-1]; 
		
			if ((($tabelafinal[$linha][$_SESSION['qtdecolunas']-1])!=0)  and  (($tabelafinal[$linha][$coluna])!=0))
			{
			  //calculo
			  $deltas[$linha-1][$aux]   =   (round(((($b*-1)/$f)),0)+$vlrb);
		
			}else{
			  $deltas[$linha-1][$aux]=0+$vlrb; 
			}
		
			if( $deltas[$linha-1][$aux] < $minima)
			{
			  $minima=$deltas[$linha-1][$aux];
			}
		
			if( $deltas[$linha-1][$aux] > $maxima)
			{
				$maxima=$deltas[$linha-1][$aux];
			}
		  }
		  $lmax[$aux]=$maxima;
		  $lmin[$aux]=$minima;
		  $aux++;
		  $aux2++;
		}
		
		$conteudo.='<h3><strong>Limites</strong></h3><br>';
		$conteudo.='<p><strong>Limite Mínimo :</strong> Indica o menor valor que cada variável(recurso) pode assumir, considerando que todas as outras não se alterem para que a solução contenue viável.</p>';
		$conteudo.='<p><strong>Limite Máximo :</strong> Indica o maior valor que cada variável(recurso)  pode assumir, considerando que todas as outras não se alterem para que a solução continue viável. </p><br><br>';
		
		//escreve os calculos feitos e os limites minimos e maximos 
		$aux=0;
		$aux2= 1;
		for ($coluna=($_SESSION['qtdevariaveis']+1); $coluna < ($_SESSION['qtdecolunas']-1) ; $coluna++) 
		{
		  $conteudo.='<strong>'.$tabelafinal[0][$coluna].'</strong><br>'; 
		  for ($linha=1; $linha < ($_SESSION['qtdelinhas']-1); $linha++) 
		  {
			if (  ($tabelafinal[$linha][$_SESSION['qtdecolunas']-1])!=0  and   ($tabelafinal[$linha][$coluna]) !=0)
			{
			  $b = ($tabelafinal[$linha][$_SESSION['qtdecolunas']-1]);
			  $f =  ($tabelafinal[$linha][$coluna]);
			  $vlrb = $tabelainicial[$aux2][$_SESSION['qtdecolunas']-1]; 
			  //escreve o resultado do calculo arredondado
		
			  $conteudo.='<strong>Minimo :'.$lmin[$aux].'</strong><br>';
			  $conteudo.='<strong>Máximo :';
			  //este calculo é apenas vizualização, o valor foi armazenado no array $deltas na linha 124
			  $conteudo.=($b*-1).' /  '.$f.' + '.$vlrb.' = '.  (round(((($b*-1)/$f)),2)+$vlrb).'<br>';
			}
		  }
		
		  $lmax[$aux].'</strong><br>';
		  $conteudo.='<br><hr>';
		  $aux++;    
		  $aux2++;
		}
		
		$conteudo.='<br/><br/><h4> Se o valor de Sombra for 0, o valor minimo e máxiimo serão mostrados os valores iniciais</h4>';
		
		//adiciona na 3 coluna da tabela preço sombra os limites minimos
		for ($linha=0; $linha <count($lmin) ; $linha++)
		{ 
		  $tabelaprecosombra[$linha][2] = $lmin[$linha];
		}
		
		//adiciona na 4 coluna da tabela preço sombra os limites maximos
		for ($linha=0; $linha <count($lmax) ; $linha++)
		{ 
		  $tabelaprecosombra[$linha][3] = $lmax[$linha];
		}
		
		//adiciona na ultima coluna da tabela preco sombra os valores de B,  caso a linha seja um F
		$aux =0;
		for ($linha=0; $linha <$_SESSION['qtdelinhas'] ; $linha++)
		{ 
		  if ((substr(strtoupper(trim($tabelainicial[$linha][0])),0,1)=='F'))
		  {
			  $tabelaprecosombra[$aux][4] = $tabelainicial[$linha][$qtdecolunas-1];
			  $aux++;
		  }
		}
		
		$conteudo.='<div class="row"><div class="col-lg-12">';
		$conteudo.='<table class="table table-bordered"><thead><tr>';
		$conteudo.='<th>Recursos</th>';
		$conteudo.='<th>Preço Sombra</th>';
		$conteudo.='<th>Limite Mínimo</th>';
		$conteudo.='<th>Limite Máximo</th>';
		$conteudo.='<th>Valor Inicial (B)</th>';
		$conteudo.='</tr></thead>';
		$conteudo.='<tbody>';
		
		for ($l=0; $l <= 4 ; $l++) 
		{
		  $conteudo.='<tr>'; 
		  for ($c=0; $c < $_SESSION['qtdecolunas'] ; $c++) 
		  { 
			if (isset($tabelaprecosombra[$l][$c]))
			{
			  if(trim($tabelaprecosombra[$l][$c])!='')
			  {
				$conteudo.='<td>'.$tabelaprecosombra[$l][$c].'</td>';
			  }
			}
		  }
		}
		
		$conteudo.='</tbody>';  
		$conteudo.='</tbody>';
		$conteudo.='</table>';
		$conteudo.='</div>';
		$conteudo.='<br><br>';
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