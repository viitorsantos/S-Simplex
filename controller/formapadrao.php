<?php
session_start();
require_once('view/conteudo.php');


class formapadrao
{
	public function __construct() {
					
			
			
			$conteudo='<h1 style="text-align:center;">Forma Padrão</h1>';
			$conteudo.='<h5 style="text-align:center;">Nesta etapa a fórmula é modificada  para a forma padrão e inclui-se as variáveis de folga.</h5><br><br>';
			$conteudo.='<lu>';
			$folga=1;
			
			for ($l=1; $l <= $_SESSION['qtderestricoes'] ; $l++)
			{ 
				if($_REQUEST['relacao'.$l]=='<=')
				{
					$conteudo.='<li>Como a restrição '.$l.' é do tipo '.$_REQUEST['relacao'.$l].' adiciona-se a variável de folga 
					F'.$folga.';
					</li>';
					$_SESSION['folga'.$l]=1;
				}
			
				if($_REQUEST['relacao'.$l]=='>=')
				{
					$conteudo.='<li>Como a restrição '.$l.' é do tipo '.$_REQUEST['relacao'.$l].' adiciona-se a variável de folga 
					-F'.$folga.';
					</li>';
					$_SESSION['folga'.$l]=-1;
				}
				$folga++;	
				$_SESSION['relacao'.$l]=$_REQUEST['relacao'.$l];
			}
			
			
			$conteudo.='<div  class="col-lg-6 row-func">';
			
			if ($_SESSION['objetivo']=='max')
			{
				$conteudo.='<strong>Maximizar  </strong>';
			}else{
				$conteudo.='<strong>Minimizar  </strong>';
			}
			
			//escreve a funcao Z
			$funcao='';
			for ($c=1; $c <= $_SESSION['qtdevariaveis'] ; $c++)
			{ 
				$funcao=$funcao.$_REQUEST['z'.$c].'X<sub>'.$c.'</sub>';
				$_SESSION['z'.$c]=$_REQUEST['z'.$c];
				if($c<$_SESSION['qtdevariaveis'])
				{
					$funcao=$funcao.' + ';
				}
			}
			$conteudo.=$funcao.'<br><br>';
			
			//escreve as restrições
			for ($l=1; $l <= $_SESSION['qtderestricoes'] ; $l++)
			{ 
				for ($c=1; $c <=$_SESSION['qtdevariaveis']; $c++)
				{ 
					$conteudo.=
					$_REQUEST['r'.$l.'_'.$c].'X<sub>'.$c.'</sub>';
					$_SESSION['r'.$l.'_'.$c] = $_REQUEST['r'.$l.'_'.$c];
					if($c<$_SESSION['qtdevariaveis'])
					{
						$conteudo.=' + ';	
					}else{
						$conteudo.=' '.$_REQUEST['relacao'.$l].' '.$_REQUEST['resultado'.$l];
						$_SESSION['relacao'.$c] = $_REQUEST['relacao'.$l];
						$_SESSION['resultado'.$l] = $_REQUEST['resultado'.$l];
					}
				}
				$conteudo.='<br>';
			}
			
			$conteudo.=$_SESSION['restricaopadrao'];
			$conteudo.='</div">';
			$conteudo.=' </div><div class="col-lg-6 row-func">';
			
			if ($_SESSION['objetivo']=='max')
			{
				$conteudo.='<strong>Maximizar   </strong>';
				$_SESSION['objetivo2']='+';
			}else{
				$conteudo.='<strong>Minimizar  </strong>';
				$_SESSION['objetivo2']='-';
			}
			
			$funcao='';
			for ($c=1; $c <= $_SESSION['qtdevariaveis'] ; $c++)
			{ 
				$funcao=$funcao.$_REQUEST['z'.$c.''].'X'.$c.'>';
				$_SESSION['z'.$c.'']=$_REQUEST['z'.$c.''];
				if($c<$_SESSION['qtdevariaveis'])
				{
					$funcao=$funcao.' + ';
				}
			}
			
			$aux=1;
			$funcao=$funcao.' + ';
			
			for ($l=1; $l <=$_SESSION['qtderestricoes']; $l++)
			{ 
				if ($_SESSION['folga'.$l]>0)
				{
					$funcao=$funcao.$_SESSION['folga'.$l].'F'.$aux.'';
					$aux++;
				}else{
					$funcao=$funcao.'('.$_SESSION['folga'.$l].'F'.$aux.')';
					$aux++;
				}
			
				if($l<$_SESSION['qtderestricoes'])
				{
					$funcao=$funcao.' + ';
				}
			}
			
			
			
			$conteudo.=$funcao.'<br><br>';
			//escreve as restrições com as variaveis
			$aux = 1;
			for ($l=1; $l <= $_SESSION['qtderestricoes'] ; $l++) { 
				for ($c=1; $c <=$_SESSION['qtdevariaveis']; $c++) { 
					$conteudo.=
					$_REQUEST['r'.$l.'_'.$c].'X'.$c.'';
					$_SESSION['r'.$l.'_'.$c] = $_REQUEST['r'.$l.'_'.$c];
					if($c<$_SESSION['qtdevariaveis'])
					{
						$conteudo.=' + ';	
					}else{
						if ($_SESSION['folga'.$l]>0)
						{
							$conteudo.=' + '.$_SESSION['folga'.$l].'F'.$aux.'';
							$aux++;
						}else{
							$conteudo.=' + ('.$_SESSION['folga'.$l].'F'.$aux.') ';
							$aux++;
						}
			
						$conteudo.=' = '.$_REQUEST['resultado'.$l];
						$_SESSION['relacao'.$c] = $_REQUEST['relacao'.$l];
						$_SESSION['resultado'.$l] = $_REQUEST['resultado'.$l];
					}
				}
				$conteudo.='<br>';
			}
			
			$funcao='';
			for ($c=1; $c <= $_SESSION['qtdevariaveis'] ; $c++)
			{ 
				$funcao=$funcao.'X<sub>'.$c.'</sub>';
				$_SESSION['z'.$c.'']=$_REQUEST['z'.$c.''];
				if($c<$_SESSION['qtdevariaveis'])
				{
					$funcao=$funcao.' , ';
				}
			}
			
			$aux=1;
			for ($l=1; $l <= $_SESSION['qtderestricoes']; $l++)
			{ 
				$funcao=$funcao.' , '.'F<sub>'.$aux.'</sub>';
				$aux++;
			}
			
			$funcao=$funcao.' >= 0';
			$conteudo.=$funcao;
			$conteudo.='</div">';
			
			$conteudo.=
			'
			</div></div></div>
			<br><br>
			<form style="text-align:center;" action="?pag=resultado" method="GET"  class="form-horizontal">
				<input type="hidden" name="pag" value="resultado" />
				<fieldset>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="checkbox-inline"  for="passoapasso-0">
									<input type="checkbox" checked name="passoapasso" value="S">Adicionar o passo a passo?</label>
							</div>
						</div>
						<div class="col-md-12 text-left">
							<button id="submit" name="submit" class="btn btn-next btn-next-green">Próximo</button>
						</div>
					</div>
					</div>
				</fieldset>
			</form>
			';
			
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
			