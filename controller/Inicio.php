<?php
require_once('view/conteudo.php');

class Inicio
{
	public $conteudo;
	public function __construct() {
	
		
		
		$conteudo='
		  <form class="form-horizontal" action="?pag=restricoes" method="GET">
			<input type="hidden" name="pag" value="restricoes" />
			  <!-- Form Name -->
				<legend class="text-center">Simples de Simplex - Insira os valores para calcular o simplex.</legend>
		
			  <!-- Entrada de Texto -->
			  <div class="row">
			  	<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
				<div class="form-group">
				  <label class="control-label" for="qtdevariaveis">Digite aqui a quantidade de variáveis.</label>  
				  <div>
					<input id="qtdevariaveis" name="qtdevariaveis" type="number" step="1" class="form-control input-md" required="">
				  </div>
				</div>
				</div>
		
			  <!-- Entrada de Texto -->
			  <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
				<div class="form-group">
				  <label class=" control-label" for="qtderestricoes">Digite aqui a quantidade de restrições</label>  
				  <div>
					<input id="qtderestricoes" name="qtderestricoes" type="number" step="1" class="form-control input-md" required="">
				  </div>
				</div>
				</div>
		
			  <!-- Seleção do Modo Max ou Min -->
			  <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
				<div class="form-group">
				  <label class="control-label" for="objetivo">Qual é o objetivo da função?</label>
				  <div>
					<select id="objetivo" name="objetivo" class="form-control">
					  <option value="max">Maximizar</option>
					  <option value="min">Minimizar</option>
					</select>
				  </div>
				</div>
				</div>
		
			  <!-- Button -->
			  <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
				<div class="form-group">
				  <label class="control-label" for="submit"></label>
				  <div>
					<button name="submit" class="btn btn-next btn-next-green">Próximo</button>
				  </div>
				</div>
				</div>
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