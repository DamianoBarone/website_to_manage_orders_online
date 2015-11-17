<?php

session_start();
date_default_timezone_set('Europe/Rome');
$host = "localhost";
$user = "root"; 
$password = ""; 
$db = "tia"; 
$connessione = mysql_connect($host,$user,$password) or die(mysql_error());
mysql_select_db($db,$connessione) or die(mysql_error());
	
if(isset($_POST['email'])) //mi salvo la sessione
{
	$_SESSION['email']=$_POST['email']; //per ricordare;
	$_SESSION['nome']=$_POST['nome'];
}
if(isset($_POST['login']))
{
	$_SESSION['email']=$_POST['login'];
	$risu=mysql_query('select nome from account where email="'.$_POST['login'].'"');//recupero nome
	$r = mysql_fetch_array($risu);
	$_SESSION['nome']=$r['nome'];
	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html lang='it'>
<head>
<title>Terrazzo Azzurro</title>

<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" >
<meta name="author" content="Damiano Barone">
<meta name="keywords" content="Terrazzo Azzurro casuzze  Marina di Ragusa,  Terrazzo Azzurro ristorante, Terrazzo Azzurro pizzeria, pizza asporto, casa vacanze home oliday, terrazzo azzurro restaurant, terrazza bar">  
<meta name="description" content="Affitto casa vacanze viletta a Casuzze , a pochi passi da marina di ragusa e caucana">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"> 
<script type="text/javascript" src="./js/controllo.js"> </script>
</head>
<body onload="loading()">
<!--==============================header=================================-->

   <div class="row-top">  <!--nero di sopra -->
      <img  ALT ="terrazzo azzurro.com" class="titol" src="images/titolo.png">
	      <ul class="menu">
            <li><a  href="index.html">Home</a></li>
            <li><a href="terrazzo_azzurro_info.html">Info sito</a></li>
            <li><a href="terrazzo_azzurro_pizzeria.html">Photo gallery</a></li>
            <li><a href="terrazzo_azzurro_faq.html">FAQ </a></li>
            <li><a class="active" href="terrazzo_azzurro_prenotazione.php"> Prenotazioni</a></li>
            <li><a href="terrazzo_azzurro_contact.html">Contatti</a></li>
          </ul>
    </div>
<div class="content content4">
<?php
if (isset($_SESSION['email']))
	{   //se la sessione e' gia attiva	
	if (isset($_POST['nome']))//se è vero utente appena registrato
		{
		$query =mysql_query( "SELECT nome FROM `account` WHERE email= '".$_SESSION['email']."'")or die(mysql_error());
		$res_num = mysql_num_rows($query);
		if (!$res_num)		 
			{
				mysql_query("INSERT INTO `tia`.`account` (`email`, `nome`, `cognome`, `pass`, `telefono`, `indirizzo`) VALUES ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['cognome']."', '".$_POST['pass']."', '".$_POST['telefono']."', '".$_POST['indirizzo']."');") or die(mysql_error());
				echo '<p class="spostamento2"> complimenti ti sei registrato '.$_SESSION["nome"].'<a class="linea" href="logout.php"> Log Out</a></p><br>';
				ordinazione();
			}
		else //utente gia registrato
			{
				echo ' <span class="errore errore2"> utente già registrato </span> '; 			
				$_SESSION = array();
				testo();
			}
		
		}
	else //controllo login
	{
		if(isset($_POST['login']) )
	{ 	
		
		$risultato=mysql_query('select nome, email from account where email="'.$_POST['login'].'" AND pass="'.$_POST['password'].'"');
		$result = mysql_fetch_array($risultato);
		if ($result["nome"]!=null)
		{	
			if($result["email"]!='admin@terrazzo.com') //utente normale
			{	
				echo '<p class="spostamento2"> CIAO '.$_SESSION["email"].'&nbsp <a class="linea" href="logout.php"> Log Out</a></p><br>';
				ordinazione();			
			}
			else 
				amministratore();
		}
		else
		{	
			echo '<span class="errore errore1"> Email Incoretta <br> o <br> Password Incoretta</span>';
			$_SESSION = array();
			testo();
		}
	}
	else 
	{
		if(isset($_POST['cancellapizza'])) //mandato posta cancella pizza
		{  
			$parte = explode("_", $_POST["elenco"]);    //elenco preso dal menu a tendina mi serve la seconda posizione per avere l'id
			$i=0;
			$val=$parte[1];
			while($i<=2)
			{  
				$i=$i+1;     //elimina tutte le pizze relative a quel nome cioe' baby,normale,maxi
				mysql_query("DELETE FROM `tia`.`pizze` WHERE `idpizza`='".$val."'");
				$val=$val+1;
			}			
			amministratore();		
		}
		else
		{
			if (isset($_POST['elem']))   //mi serve per quando clicco sulla check aggiorna id del db e mette l'ordinaziozione in completate.
			{ 	
				$ind;
				foreach ($_POST['elem'] as $indice => $valore)
				{
					if ($valore='ON')
					{
						$ind=$indice;
						break;
					}	
				}
				
				mysql_query("UPDATE tia.prenotazione SET completata=1 WHERE idprenotazione='".$ind."'");				
				amministratore();
			}					
			else
			{  
				if(isset($_POST['nomepizza'])) //aggiunge una pizza al menu
				{				 
					mysql_query("INSERT INTO `tia`.`pizze` ( `ingredienti`, `prezzo`, `nomepizza`) VALUES ('".$_POST['descrizione']."', '".$_POST['pbaby']."', '".$_POST['nomepizza']."');")or die(mysql_error());
					mysql_query("INSERT INTO `tia`.`pizze` ( `ingredienti`, `prezzo`, `nomepizza`) VALUES ('".$_POST['descrizione']."', '".$_POST['pnormale']."', '".$_POST['nomepizza']."');")or die(mysql_error());
					mysql_query("INSERT INTO `tia`.`pizze` ( `ingredienti`, `prezzo`, `nomepizza`) VALUES ('".$_POST['descrizione']."', '".$_POST['pmaxi']."', '".$_POST['nomepizza']."');")or die(mysql_error());
					amministratore();
					echo'<div class="aggiuntapizza" id="aggpizza">Pizza Aggiunta con successo</div>';
				}
				else
				{
				if(isset($_POST['Invia'])) //inserisce una nuova prenotazione
				{
					$data=time();     
					$data=date('Y-m-d H:i:s', $data); 					
					mysql_query("INSERT INTO `tia`.`prenotazione` (`dataprenotazione`, `email`) VALUES ('".$data."', '".$_SESSION['email']."');") or die(mysql_error());
					$id = mysql_query("SELECT MAX(idprenotazione) FROM prenotazione");  //mi da l'id della prenotazione auto increment
					$id=mysql_fetch_array($id);
					while (list($key, $value) = each($_POST))  //sintassi per ogni chiave c'e' un valore
					{						 
						if ($value!='invia')
							{$parte = explode("_", $value);
							
							mysql_query("INSERT INTO `tia`.`pizzeprenotate` (`idprenotazione`,`idpizza`, `quantita`) VALUES ('".$id["MAX(idprenotazione)"]."', '".$parte['2']."', '".$parte['0']."' );") or die(mysql_error());
							}			
					}
					conferma($id["MAX(idprenotazione)"]);
				}
				else
				{
					if(isset($_POST['c'])) //cerca una prenotazione
					{	
						conferma($_POST['c']);
					}
					else
						{if($_SESSION["email"]=='admin@terrazzo.com')		 // caso in cui faccio refresh delle pagina			   
							amministratore();
						else
							{
							echo '<p class="spostamento2"> CIAO '.$_SESSION["nome"].'&nbsp <a class="linea" href="logout.php"> Log Out</a></p><br>';
								ordinazione();			
							}
				}	}
			
			}}
	
	   }
	}
	}
}
else 
	testo();
	
	 //altrimenti visualizza normale
 
 mysql_close();

 function ordinazione() //pagina che permette ad un utente di prenotare le pizze
 { echo "
			<img alt=' 'src='images/moto.png'>
			<div class='testo titolo'>
			Qui puoi ordinare le tue pizze d' asporto!<br>
			&nbsp Per aggiungere una pizza al carrello, basta un click <br> &nbsp &nbsp sul prezzo della pizza che preferisci.<br> &nbsp &nbsp &nbsp &nbsp &nbsp Dopo l'ordine ti diremo quando venire in pizzeria a <br>&nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp ritirare le tue pizze!!!</div>
	  ";
 	$risultato=mysql_query('select * from pizze');
	echo '
	<form action="terrazzo_azzurro_prenotazione.php" method="post" name="modulo2">
    <div id="carrello" class="carrello">
        <div class="titolo spostamento3">CARRELLO</div>
        <span class="titolo">NOME</span><span class="titolo spostamento1">PREZZO</span> 
        <span class="titolo spostamento2">QNT</span> 
    </div>
	</form>
	<table class="tabella1" border="10" cellspacing="10">
    <tr>
        <th class="nero cellatesto" rowspan="2">Nome</th>
        <th class="nero cellatesto" rowspan="2">Ingredienti</th>
        <th class="nero cellatesto" colspan="3">Prezzo</th>
    </tr>
    <tr>
        <th class="nero cellaprezzo">Baby</th>
        <th class="nero cellaprezzo">Normale</th>
        <th class="nero cellaprezzo">Maxi</th>
    </tr> ';
	while($result = mysql_fetch_array($risultato)){
	echo 
			'<tr><td class=" cellatesto">'.$result["nomepizza"].'</td>
			<td class="it cellatesto">'.$result["ingredienti"].'</td><td class="nero cellaprezzo">
			<a class="linea " href="#" onclick="Cart('.$result['prezzo'].','.$result['idpizza'].',\''.$result['nomepizza'].'\')">'.$result["prezzo"].'</a></td>';
			 $result = mysql_fetch_array($risultato);
			echo '<td class=" cellaprezzo">
			<a class="linea " href="#" onclick="Cart('.$result['prezzo'].','.$result['idpizza'].',\''.$result['nomepizza'].'\')">'.$result["prezzo"].'</a></td>';
			$result = mysql_fetch_array($risultato);
			echo '<td class=" cellaprezzo">
			<a class="linea" href="#" onclick="Cart('.$result['prezzo'].','.$result['idpizza'].',\''.$result['nomepizza'].'\')">'.$result["prezzo"].'</a></td>';
			
		
	}
	echo '</table>';
 }
function testo() //pagina di login e registrazione
{
echo '<!--==============================content================================-->

<div class="login">
    <form action="terrazzo_azzurro_prenotazione.php" method="post" name="modulo1">
        <p CLASS="p3 it">Email</p>
        <div>
            <input type="text" name="login">
        </div>
        <p CLASS="p3 it">Password</p>
        <div>
            <input type="password" name="password">
            <div class="p4">
                <input type="submit" value=" Entra ">
                <input type="reset" value="Cancella">
            </div>
        </div>
    </form>
</div>

<div class="colonna4">
    <form method="post" action="terrazzo_azzurro_prenotazione.php" name="modulo">
        <div class="registrazione registrazioneaccount">

            Nome(*)
            <div>
                <input type="text" name="nome" maxlength="44" tabindex="10"><span class="spanCampo" id="err0"></span>
            </div>
            Cognome(*)
            <div>
                <input type="text" name="cognome" maxlength="44" id="inputRegistrazioneCognome" tabindex="11"><span class="spanCampo" id="err1"></span>
            </div>
            Password(*)
            <div>
                <input type="password" name="pass" maxlength="44" tabindex="12"><span class="spanCampo" id="err2"></span>
            </div>
            Conferma Password(*)
            <div>
                <input type="password" maxlength="44" name="conferma" tabindex="13"><span class="spanCampo" id="err3"></span>
            </div>
            Email(*)
            <div>
                <input type="text" name="email" maxlength="44" id="inputRegistrazioneEmail" tabindex="14"><span class="spanCampo" id="err4"></span>
            </div>

            Telefono(*)
            <div>
                <input type="text"  name="telefono" tabindex="15" maxlength="10"><span class="spanCampo" id="err5"></span> 
            </div>
            indirizzo(*)
            <div>
                <input type="text" maxlength="44" name="indirizzo" tabindex="16"><span class="spanCampo" id="err6"></span> 
            </div>
            <div>
                <br>
                <input type="button" value=" Registrati" onclick="Modulo()">
                <input type="reset" value="Cancella">
            </div>
        </div>
    </form>
</div>


<!--==============================footer=================================-->
';
}

function amministratore() // pagina per gestire ordinazione e prenotazioni
{
echo'
	 <div class="spostamento2" >Ciao Amministratore <a class="linea" href="logout.php"> Log Out</a> <br></div>';

	$risultato=mysql_query('select * from pizze');
		
	echo " 
	<div class='cerca titolo nero'>CERCA PRENOTAZIONE
    <form method='post' action='terrazzo_azzurro_prenotazione.php' name='search'>
        <div>
            <input type='text' name='c'>
            <input type='button' name='bottonericerca' onclick='cerca()' value='cerca'><span class='spanCampo' id='errcerca'></span>
        </div>
    </form>
	</div>
	<div class='cancella titolo nero'>CANCELLA UNA PIZZA DAL MENU
    <form action='terrazzo_azzurro_prenotazione.php' method='post' name='modulo4'>
        <div>
            <select id='elenco' name='elenco'>";
		while($result = mysql_fetch_array($risultato)){	
			echo'<option value="'.$result["nomepizza"].'_'.$result["idpizza"].'">'.$result["nomepizza"].'</option>';
				$result = mysql_fetch_array($risultato);$result = mysql_fetch_array($risultato);
			}
			echo'</select>
			<input type="submit" name="cancellapizza" value="cancella pizza">
			</div></form></div>';
		echo'<form method="post" action="terrazzo_azzurro_prenotazione.php" name="pizza">
    <div class="registrazione registrazionepizza">
        <span class=" titolo nero">INSERISCI UNA NUOVA PIZZA </span>
        <BR>Nome(*)
        <div>
            <input type="text" name="nomepizza" tabindex="10" maxlength="44"><span class="spanCampo" id="pizza0"></span>
        </div>
        Ingredienti(*)
        <div>
            <input type="text" name="descrizione" maxlength="69" tabindex="11"><span class="spanCampo" id="pizza1"></span>
        </div>
        prezzobaby (*)
        <div>
            <input type="text" name="pbaby" tabindex="12"><span class="spanCampo" id="pizza2"></span>
        </div>
        prezzonormale(*)
        <div>
            <input type="text" name="pnormale" tabindex="13"><span class="spanCampo" id="pizza3"></span>
        </div>
        prezzomaxi(*)
        <div>
            <input type="text" name="pmaxi" tabindex="14"><span class="spanCampo" id="pizza4"></span>
        </div>
        <br>
        <input type="button" value=" inserisci pizza" onclick="modulopizza()">
        <input type="reset" value="Cancella">
    </div>
	</form>';
			$ordini=mysql_query("select pizzeprenotate.idprenotazione, nomepizza, quantita,pizzeprenotate.idpizza from prenotazione, pizzeprenotate,pizze 
where prenotazione.idprenotazione=pizzeprenotate.idprenotazione AND pizze.idpizza=pizzeprenotate.idpizza AND completata=0 order by idprenotazione");
			echo 	'<div class="colonna4 cl4">
    <form method="post" action="terrazzo_azzurro_prenotazione.php" name="Ordini">
        <table class="tabella2" border="10" cellspacing="10">
            <caption>
                <Em> <span class="color-2 titolo" >Prenotazioni ancora attive </span></Em>
            </caption>
            <tr>
                <th class="cellatesto2 nero">Completata</th>
                <th class="cellatesto2 nero">idprenotazione</th>
                <th class="cellatesto2 nero">Nome</th>
                <th class="cellatesto2 nero">Dim</th>
                <th class="cellatesto2 nero">QNT</th>
            </tr>';
			$ordinevecchio=-1;
			while($ordine = mysql_fetch_array($ordini)){
				if ($ordinevecchio==$ordine["idprenotazione"])
					echo'<tr><th class="rigadestra"></th><th></th>';
				else 
					{$ordinevecchio=$ordine["idprenotazione"];
					echo '<tr><th class="rigaAlta rigadestra"><input type="checkbox" name="elem['.$ordine["idprenotazione"].']" onclick="check()"></th><th class="rigaAlta">'.$ordine["idprenotazione"].'</th>';
					}
					$dimensione=($ordine["idpizza"]%3);  //controlla la dimensione
					$dimensione=($dimensione==0)?'Baby':(($dimensione==1)?'Norm':'Maxi');
			echo'<td class="cellatesto2">'.$ordine["nomepizza"].'</td><td class="cellatesto2">'.$dimensione.'</td><td class="cellatesto2">'.$ordine["quantita"].'</td>';
			}
			echo'</table></form></div>';
					
}
function conferma($id) //stessa pagina sia per la conferma di una prenotazione sia per la ricerca di una prenotazioen
{
$somma=0;
$tot=0;
$qnt=mysql_query("select quantita from prenotazione, pizzeprenotate
where prenotazione.idprenotazione=pizzeprenotate.idprenotazione AND completata=0");
	while($somma = mysql_fetch_array($qnt)){
		$tot+=$somma["quantita"];
	}
	$tot*=1.35;
	$tot=round($tot);
	$tab=mysql_query("select pizzeprenotate.idprenotazione, prenotazione.email, nomepizza, quantita,pizzeprenotate.idpizza,prezzo from prenotazione, pizzeprenotate,pizze 
where prenotazione.idprenotazione=pizzeprenotate.idprenotazione AND pizze.idpizza=pizzeprenotate.idpizza AND pizzeprenotate.idprenotazione=".$id)or die(mysql_error());
	$res_num = mysql_num_rows($tab);
	if (!$res_num)
	{
	echo'<div class="aligncenter color-2"> <strong>ID NON CORRETTO <BR></strong><a class="color-2 linea" href="terrazzo_azzurro_prenotazione.php"> TORNA INDIETRO </a></div>';
				
	}
	else
	{
	$x= mysql_fetch_array($tab);
	echo'<div class="aligncenter testo nero">ORDINE <strong class="color-2"> '.$id.'<br> </strong><SPAN class="nero">ACCOUNT</span> <strong class="color-2">'.$x["email"].'</strong><br>';
		if (!isset($_POST["c"]))echo'	ACCETTATO TEMPO PREVISTO <strong class="color-2">'.$tot.' </strong>minuti<br>';//caso prenotazione
echo'	RIEPILOGO</div>';
	echo 	'<div class="colonna2  cl4"><form method="post" action="terrazzo_azzurro_prenotazione.php" name="Ordini"><table class="tabella2" border="10" cellspacing="10">
			<tr><th class="cellatesto2" > Nome</th><th class="cellatesto2" > Dim</th><th class="cellatesto2"> QNT</th><th class="cellatesto2"> Prezzo</th></tr>';
		$somma=0;
	do {
			$dimensione=($x["idpizza"]%3);  //controlla la dimensione
					$dimensione=($dimensione==0)?'Baby':(($dimensione==1)?'Norm':'Maxi');
			echo'<tr><td class="cellatesto2">'.$x["nomepizza"].'</td><td class="cellatesto2">'.$dimensione.'</td>
			<td class="cellatesto2">'.$x["quantita"].'</td><td class="cellatesto2">'.$x["prezzo"].'</td></tr>';
				$somma+=$x["quantita"]*$x["prezzo"];
			}while($x= mysql_fetch_array($tab));
			
			echo'<tr><td class="cellatesto2" colspan="3">TOTALE</td><td class="cellatesto2">'.$somma.'</TD></tr>
				</table></form></div> <br> <div class="tp "><strong><a class="nero linea" href="terrazzo_azzurro_prenotazione.php"> Torna indietro</a></strong></div> ';
}
}
 ?>
 
</div>

  <div class="footer footer4">  
    <div class="aligncenter"> <span>Copyright &copy; <a href="#">www.terrazzoazzurro.com</a> All Rights Reserved</span> Design by <a  href="mailto:damiano.barone@gmail.com"> Damiano Barone </a></div>

</div>
</body>
</html>
