<?php
require_once('classes/HTMLtags.class.php');

$tag = new tags();
$tag->loadCss('css/');
function dia($tag){
	return $tag->inprime("Meu calendário PHP. Hoje é dia ".date('d/m/Y'),'decode');
}

function item_calendario($tag,$dia){

	$dias_do_mes = dias_do_mes($dia);	
	$nome_do_mes  = nome_do_mes($dia);
	$dia_inicial = 0;
	$dia_da_semana = jddayofweek( cal_to_jd(CAL_GREGORIAN, $dia,"01",date('Y')) , 0 );	
	$tag->open('table','id="item_calendario" border="1"');
		dias_da_semana($tag,$dia);
		for($i=0; $i<6; $i++):
			$tag->open('tr','align = "center"');
				for($j=0; $j<7; $j++):
					if($dia_inicial + 1 <= $dias_do_mes):
						if($j < $dia_da_semana && $i==0):
							$tag->open('td','id="vazio"');
								$tag->inprime('');
							$tag->close('td');
						else:
							$tag->open('td');
								$tag->inprime(++$dia_inicial);
							$tag->close('td');
						endif;
					else:
						break;
					endif;	
				endfor;	
			$tag->close('tr');	
		endfor;
	$tag->close('table');
}

function dias_do_mes($mes){
	$dias = array('01' => 31, '02' => 28, '03' => 31, '04' =>30, '05' => 31, '06' => 30,
				  '07' => 31, '08' =>31, '09' => 30, '10' => 31, '11' => 30, '12' => 31);
 
	if (((date('Y') % 4) == 0 and (date('Y') % 100)!=0) or (date('Y') % 400)==0):
	    $dias['02'] = 29;
	endif;
 
	return $dias[$mes];
}

function nome_do_mes($mes){
     $meses = array( '01' => "Janeiro", '02' => "Fevereiro", '03' => utf8_decode("Março"),
                     '04' => "Abril",   '05' => "Maio",      '06' => "Junho",
                     '07' => "Julho",   '08' => "Agosto",    '09' => "Setembro",
                     '10' => "Outubro", '11' => "Novembro",  '12' => "Dezembro");
 
 	if($mes >= 01 && $mes <= 12):
 		return $meses[$mes];
 	else:
 		return "Mês inválido";
	endif; 
}

function dias_da_semana($tag,$mes,$dias = array('Dom','Seg','Ter','Qua','Qui','Sex','Sab')){
	$tag->open('div','id="mes_title"');
		$tag->open('small');
			$tag->inprime(nome_do_mes($mes));
		$tag->close('small');
	$tag->close('div');
	for($i=0; $i<=count($dias)-1; $i++):
		$tag->open('th','id="label_mes"');
			$tag->inprime($dias[$i]);
		$tag->close('th');
	endfor;
}

function calendario($tag){
	$cont = 1;
	$tag->open('div','id="calendario-panel" align = "center"');
	$tag->open('table','id="calendario"');
		for($i=0; $i<3; $i++):
			$tag->open('tr');
				for($j=0; $j<4; $j++):
			 		$tag->open('td');
						item_calendario($tag,($cont<10) ? "0".$cont : $cont);  
			        	$cont++;
			 		$tag->close('td');
	 			endfor;
	 		$tag->close('tr');
	 	endfor;
	$tag->close('table');
}
dia($tag);
calendario($tag);

?>
