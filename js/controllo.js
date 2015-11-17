var prezzototale = 0; //mi servira' per il totale
var id = 0; //identificatore di un  valore precedente di una select 
var valoriprecedenti = new Array();//mi ricorda le select precedenti
var righe = new Array(); //segna gli id delle select  ancora presenti
var ultimo = -1; //indice ultima riga

function loading() {
    if (document.getElementById("elenco") != null)
        setTimeout("redirect()", 300000); //refresh per l'amministratore


}

function Cart(prezzo, idpizza, nome) // gestisco il carrello
{ var control = false; // controlla se la pizza e' gia presente
    var nomeselect;
    var menu;

    for (var i = 0; i <= ultimo; i++) {
        var nomeselect = righe[i]; //ho il nome della select che corrisponde all'indice dei valori precedenti
        if (valoriprecedenti[nomeselect][2] == idpizza) // gia presente quella riga ,aumento select di 1
        {
            control = true;
            if ((valoriprecedenti[nomeselect][0] == 9)) //controllo di non superare il 9
            {
                alert("non puoi ordinare piu' di 9 pizze");
                break;
            }
            cambioselect((valoriprecedenti[nomeselect][0] + 1), nomeselect); //richiamo funziona che aggiorna i valori
            menu = document.getElementsByName(nomeselect)[0]; //recupero l'oggetto select per cambiargli l'opzione
            menu.selectedIndex = valoriprecedenti[nomeselect][0] - 1; //-1 PERCHE vuole l'indice della select quindi se voglio 3, array[2]=3			
            break;
        }

    }
    if (!control) //se false significa che devo aggiungere riga
    {
        id++;
        ultimo++; //aumento di riga
        valoriprecedenti[id] = new Array(3);
        valoriprecedenti[id][0] = 1; //quantita' select all'inizio ha 1
        valoriprecedenti[id][1] = prezzo; // prezzo  della pizza
        valoriprecedenti[id][2] = idpizza; //mi  segno l'id pizza

        righe[ultimo] = id; //mi segno il nome della select 

        var ctxt = document.getElementById("carrello");
        if (prezzototale != 0) //se c'e' gia un figlio
            ctxt.removeChild(ctxt.lastChild); // tolgo totale e figlio
        prezzototale += prezzo; //incremento il totale
        var dimensione = (idpizza % 3); //per riconoscere se e' una baby e normale  o maxi mi basta sapere il resto della divisione 3
        dimensione = (dimensione == 0) ? 'B' : ((dimensione == 1) ? 'N' : 'M');
        var txt = document.createTextNode(nome + ' ' + dimensione);
        var p = document.createElement('div'); //div della riga
        p.className = 'p3';
        p.appendChild(txt);
        var newDiv = document.createElement('span'); //per il prezzo
        newDiv.className = 'spostamento1';
        var txt = document.createTextNode(" € " + prezzo);
        newDiv.appendChild(txt);
        p.appendChild(newDiv);
        var choices = []; //le varie scelte della select
        choices[0] = "1";
        choices[1] = "2";
        choices[2] = "3";
        choices[3] = "4";
        choices[4] = "5";
        choices[5] = "6";
        choices[6] = "7";
        choices[7] = "8";
        choices[8] = "9";
        choices[9] = "0";
        var newDiv = document.createElement('span');
        newDiv.className = "spostamento2";
        var select = document.createElement('select'); //creo la select
        select.setAttribute("id", 'i' + id);
        select.setAttribute("name", id);
        select.setAttribute("onchange", "cambioselect(this.options[this.options.selectedIndex].value,this.name)");
        for (i = 0; i < choices.length; i++) { // creo le varie opzioni
            var opzione = document.createElement('option');
            opzione.setAttribute("value", choices[i] + "_" + nome + "_" + idpizza); // separo diversi info, mi servira' per il post di php
            txt = document.createTextNode(choices[i]);
            if (i == 9)
                opzione.setAttribute("class", "color-2");
            opzione.appendChild(txt);
            select.appendChild(opzione);

        }
        newDiv.appendChild(select);
        p.appendChild(newDiv);
        ctxt.appendChild(p);
        newDiv = document.createElement('div'); //div per il totale
        creopulsanti(ctxt, newDiv);

    }

    control = false;
}

function creopulsanti(ctxt, newDiv) {
    paragrafo = document.createElement('div');
    paragrafo.className = 'p4';
    txt = document.createTextNode("TOTALE ");
    paragrafo.appendChild(txt);
    t = document.createElement('span');
    t.className = "spostamento1";
    txt = document.createTextNode(" € " + prezzototale);
    t.appendChild(txt);
    paragrafo.appendChild(t);
    newDiv.appendChild(paragrafo);
    paragrafo = document.createElement('div'); //aggiungo i pulsanti
    input = document.createElement('input');
    input.setAttribute('name', 'Invia');
    input.setAttribute('type', 'submit');
    input.setAttribute('value', 'invia');
    paragrafo.appendChild(input);
    input = document.createElement('input');
    input.setAttribute('type', 'button');
    input.setAttribute('value', 'Svuota Carrello');
    input.className = "spostamento2";
    input.setAttribute('onClick', 'redirect()')
    paragrafo.appendChild(input);
    newDiv.appendChild(paragrafo);
    ctxt.appendChild(newDiv);
}

function redirect() { //usato per lo svuota carello
    window.location = "terrazzo_azzurro_prenotazione.php";

}

function cambioselect(val, nome) //usata per click su una pizza gia presente nel carrello oppure se una selezione un valore nella select
{
    var j = 0;
    var valore = parseInt(val); //parsint legge il primo numero cioe' la quantita'
   
    var elimina = document.getElementById("carrello");
    if (valore == 0) //rimuovo riga
    {
		for (j = 0; j <= ultimo; j++) // COMPATTA
            if (righe[j] == nome) //cerca la riga dell'id corrispondente confronta i nome della select
                break;
										//compatta, sposta gli id da j a ultimo
        for (var i = j; i < ultimo; i++) // tutti quelli sotto
            righe[i] = righe[i + 1]; 
        prezzototale -= valoriprecedenti[nome][0] * valoriprecedenti[nome][1] //tolgo tupla dal totale	    
        elimina.removeChild(document.getElementsByName(nome)[0].parentNode.parentNode); // elimino il nonno della select che e' il div della riga
        ultimo--;
    } else //decremento o incremento array valoriprecedenti e prezzototale
    {
        if (valoriprecedenti[nome][0] > valore) //decrementato
            prezzototale -= (valoriprecedenti[nome][0] - valore) * valoriprecedenti[nome][1];
        else {
            if (valoriprecedenti[nome][0] < valore) //incremento, se stesso valore non faccio niente
                prezzototale += (valore - valoriprecedenti[nome][0]) * valoriprecedenti[nome][1];
        }
    }
    valoriprecedenti[nome][0] = valore;
    elimina.removeChild(elimina.lastChild); //elimino totale
    if (prezzototale != 0) {
        newDiv = document.createElement('div'); //ricreo totale
        creopulsanti(elimina, newDiv);
    }
}

function Modulo() { //registrazione
    var nome = document.modulo.nome.value;
    var cognome = document.modulo.cognome.value;
    var password = document.modulo.pass.value;
    var conferma = document.modulo.conferma.value;
    var email = document.modulo.email.value;
    var telefono = document.modulo.telefono.value;
    var indirizzo = document.modulo.indirizzo.value;
    var messaggi = new Array();
    messaggi[0] = "";
    messaggi[1] = " password diverse";
    messaggi[2] = " il campo può contenere solo  numeri";
    messaggi[3] = " il campo non può essere vuoto";
    messaggi[4] = " il campo deve essere di 10 numeri";
    messaggi[5] = " il campo deve essere un indirizzo email";
    messaggi[6] = " il campo può essere solo testuale";

    var controllo = new Array(7);
    for (var i = 0; i < controllo.length; i++) //svuoto errori precedenti
        svuota(document.getElementById("err" + i));
    controllo[0] = (controllanonvuoto(nome)) ? ((controllaSoloTesto(nome)) ? 0 : 6) : 3;
    controllo[1] = (controllanonvuoto(cognome)) ? ((controllaSoloTesto(cognome)) ? 0 : 6) : 3;
    controllo[2] = (controllanonvuoto(password)) ? 0 : 3;
    controllo[3] = (controllanonvuoto(conferma)) ? ((password == conferma) ? 0 : 1) : 3;
    controllo[4] = (controllanonvuoto(email)) ? ((controllaEmail(email)) ? 0 : 5) : 3;
    controllo[5] = (controllanonvuoto(telefono)) ? ((controllaSoloNumeri(telefono)) ? 0 : 2) : 3;
    controllo[6] = (controllanonvuoto(indirizzo)) ? 0 : 3;
    var c = true;
    for (var i = 0; i < controllo.length; i++) {
        if (controllo[i] != 0) //se c'e' un errore
        {
            c = false;
            document.getElementById("err" + i).focus();
            AggiungiImg(document.getElementById("err" + i)); //aggiungo immagine 
            Aggiungitxt(messaggi[controllo[i]], document.getElementById("err" + i));

        }
    }
    if (c) //tutto ok, mando
    {
        document.modulo.submit();
    } else
        return c;
}

function cerca() //cerca id prenotazione
{
    var c = document.search.c.value;
    var risultato = (controllanonvuoto(c)) ? ((controllaSoloNumeri(c)) ? 0 : 2) : 3;
    if (risultato == 0) {
        document.search.submit();
    } else {
        svuota(document.getElementById("errcerca"));
        document.getElementById("errcerca").focus();
        AggiungiImg(document.getElementById("errcerca"));
        if (risultato == 2)
            Aggiungitxt("il campo deve contenere solo numeri", document.getElementById("errcerca"));
        else
            Aggiungitxt("il campo non deve essere vuoto", document.getElementById("errcerca"));
        return false;
    }
}

function check() { //quando spunta l'amministratore su un ordine
    document.Ordini.submit();
}

function modulopizza() { //inserisce nuova pizza
    var nome = document.pizza.nomepizza.value;
    var ingredienti = document.pizza.descrizione.value;
    var prezzobaby = document.pizza.pbaby.value;
    var prezzonormale = document.pizza.pnormale.value;
    var prezzomaxi = document.pizza.pmaxi.value;
    var messaggi = new Array();
    messaggi[0] = "";
    messaggi[1] = " il campo deve contere un prezzo";
    messaggi[2] = " il campo non può essere vuoto";
    messaggi[3] = " il campo può essere solo testuale";
    var controllo = new Array(5);
    for (var i = 0; i < controllo.length; i++)
        svuota(document.getElementById("pizza" + i));
    controllo[0] = (controllanonvuoto(nome)) ? ((controllaSoloTesto(nome)) ? 0 : 3) : 2;
    controllo[1] = (controllanonvuoto(ingredienti)) ? ((controllaSoloTesto(ingredienti)) ? 0 : 3) : 2;
    controllo[2] = (controllanonvuoto(prezzobaby)) ? ((controlloprezzo(prezzobaby)) ? 0 : 1) : 2;
    controllo[3] = (controllanonvuoto(prezzonormale)) ? ((controlloprezzo(prezzonormale)) ? 0 : 1) : 2;
    controllo[4] = (controllanonvuoto(prezzomaxi)) ? ((controlloprezzo(prezzomaxi)) ? 0 : 1) : 2;
    var c = true;
    for (var i = 0; i < controllo.length; i++) {
        if (controllo[i] != 0) {
            c = false;
            document.getElementById("pizza" + i).focus();
            AggiungiImg(document.getElementById("pizza" + i));
            Aggiungitxt(messaggi[controllo[i]], document.getElementById("pizza" + i));
        }
    }
    if (c) {
        document.pizza.submit();
    } else {
        var x = document.getElementById("aggpizza");
        if (x != null) //se e' null non e' stata aggiunto il div aggiunta pizza con successo
            x.removeChild(x.firstChild);
        return c;
    }
}


function controlloprezzo(prezzo) {
    var reg = new RegExp(/^\d+([\.]{1}\d{1,2})?$/);
    if (reg.test(prezzo))
        return true;
    return false;
    //http://forum.html.it/forum/showthread/t-671317.html
}

function AggiungiImg(oggetto) {
    var nImg = document.createElement("IMG");
    nImg.setAttribute("src", "images/alert.png");
    nImg.setAttribute("alt", "errore ");
    oggetto.appendChild(nImg);
}

function Aggiungitxt(testo, oggetto) {
    var txt = document.createTextNode(testo);

    oggetto.appendChild(txt);
}

function svuota(csvuota) {

    while (csvuota.hasChildNodes())
        csvuota.removeChild(csvuota.lastChild);
}

function controllanonvuoto(elemento) {
    if ((elemento == "") || (elemento == "undefined"))
        return false;
    else return true;
}

function controllaSoloTesto(elemento) {

    var reg = new RegExp(/^([a-zA-Z]\s?)+$/);
    if (reg.test(elemento))
        return true;
    else return false;
}



function controllaSoloNumeri(elemento) {
    if (isNaN(elemento))
        return false;
    else return true;
}

function controllaEmail(elemento) {
    var reg = new RegExp(/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);

    if (reg.test(elemento))
        return true;
    else return false;
}