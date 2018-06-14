<?php
require_once('./view/conteudo.php');
//ini_set('display_errors',1);
//error_reporting(6143);
if (!empty($_REQUEST['pag']) and file_exists('./controller/'.$_REQUEST['pag'].'.php')) {
	$pagina=$_REQUEST['pag'];
	require_once('./controller/'.$pagina.'.php');
	$pagina = new $pagina();
	mostraConteudo($pagina->GetConteudo());
	
	unset($pagina);
} else {
	require_once('./controller/Inicio.php');
	$principal = new Inicio();
	mostraConteudo($principal->GetConteudo());
	unset($principal);
}

function mostraConteudo($c){
	$tela = new conteudo('Simples de Simplex','Simples de Simplex');
	$tela->SetContent($c);
	$tela->ShowTemplate();
}
?>