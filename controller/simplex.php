<?php
class Simplex
{
	public $tabela=array();
	public function SetTabela($t)
	{
		$this->tabela=null;
		$this->tabela=$t;
	}

	public function MostraTabela($tamanho,$qtdecolunas,$qtdelinhas)
	{
		$_SESSION['qtdelinhas']=$qtdelinhas;
		$_SESSION['qtdecolunas']=$qtdecolunas;
		$conteudo='';
		if($tamanho==12)
		{
			$conteudo.='<div class="row"><div class="col-lg-12">';
		}else{
			$conteudo.='<div class="col-lg-6">';
		}
		$conteudo.='<table class="table table-bordered"><thead><tr>';

		//cabeçalho              
		for ($c=0; $c <$qtdecolunas ; $c++)
		{ 
			$conteudo.='<th>'.$this->tabela[0][$c].'</th>';
		}
		$conteudo.='</tr></thead>';

		//apartir da segunda linha
		$conteudo.='<tbody>';
		for ($l=1; $l < $qtdelinhas ; $l++)
		{
			if ($l!=$qtdelinhas-1)
			{
				$conteudo.='<tr>'; 
				for ($c=0; $c < $qtdecolunas; $c++)
				{ 
					$conteudo.='<td>'.$this->tabela[$l][$c].'</td>';
				}
				$conteudo.='</tr>';
			}else{
				$conteudo.='<tr style="color:red;">'; 
				for ($c=0; $c < $qtdecolunas; $c++)
				{ 
					$conteudo.='<td>'.$this->tabela[$l][$c].'</td>';
				}
				$conteudo.='</tr>';
			}
		}
		$conteudo.='</tbody>';
		$conteudo.='</table>';
		$conteudo.='</div>';
		if($tamanho==12)
		{
			$conteudo.='</div>';
		}
		return $conteudo;
	}
	
	
	public function MostraTabelaPivo($tamanho,$qtdecolunas,$qtdelinhas,$linhaPivo,$colunaPivo)
	{
		$_SESSION['qtdelinhas']=$qtdelinhas;
		$_SESSION['qtdecolunas']=$qtdecolunas;
		$conteudo='';
		if($tamanho==12)
		{
			$conteudo.='<div class="row"><div class="col-lg-12">';
		}else{
			$conteudo.='<div class="col-lg-6">';
		}
		$conteudo.='<table class="table table-bordered"><thead><tr>';

		//cabeçalho              
		for ($c=0; $c <$qtdecolunas ; $c++)
		{ 
			$conteudo.='<th>'.$this->tabela[0][$c].'</th>';
		}
		$conteudo.='</tr></thead>';

		//apartir da segunda linha
		$conteudo.='<tbody>';
		for ($l=1; $l < $qtdelinhas ; $l++)
		{
			if ($l!=$qtdelinhas-1)
			{
				$conteudo.='<tr  >'; 
				for ($c=0; $c < $qtdecolunas; $c++)
				{ 
				
					$conteudo.='<td '.(($c==$colunaPivo or $l==$linhaPivo)?(($c==$colunaPivo and $l==$linhaPivo)?'style="background-color:#f44336a1; font-weight: bold; "':'style="background-color:#f4433645;"'):'').' >'.$this->tabela[$l][$c].'</td>';
				}
				$conteudo.='</tr>';
			}else{
				$conteudo.='<tr style="color:red;">'; 
				for ($c=0; $c < $qtdecolunas; $c++)
				{ 
					$conteudo.='<td '.(($c==$colunaPivo or $l==$linhaPivo)?(($c==$colunaPivo and $l==$linhaPivo)?'style="background-color:#f44336a1; font-weight: bold; "':'style="background-color:#f4433645;"'):'').' >'.$this->tabela[$l][$c].'</td>';
				}
				$conteudo.='</tr>';
			}
		}
		$conteudo.='</tbody>';
		$conteudo.='</table>';
		$conteudo.='</div>';
		if($tamanho==12)
		{
			$conteudo.='</div>';
		}
		return $conteudo;
	}
	

	public function MostraColunaDoPivoAnulada($tabela,$linha,$coluna)
	{
		$pivonegativo = ($tabela[$linha][$coluna])*-1;
		$Linhadopivo = $linha;
		$colunadopivo = $coluna;

		for ($linha=1; $linha < $_SESSION['qtdelinhas'] ; $linha++)
		{ 
			if (isset($tabela[$linha][0]))
			{
				//apenas validacao
				$anular = ($tabela[$linha][$colunadopivo])*-1;

				//quem vai ser anulado	
				for ($coluna=1; $coluna < $_SESSION['qtdecolunas']; $coluna++)
				{ 						
					if (isset($tabela[$Linhadopivo][$coluna]))
					{  
						//apenas validacao							
						$a=$tabela[$Linhadopivo][$coluna];
						$b=$tabela[$linha][$coluna];
						if($linha!=$Linhadopivo)
						{
							$tabela[$linha][$coluna]=($a * ($anular) + $b);
							//linha do pivo * numero que esta sendo anulado*(-1)+linha do que esta sendo anulado
						}
					}
				} 
			}
		}
		return $tabela;
	}
}
?>