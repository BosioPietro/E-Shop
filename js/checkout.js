

function cambiaQuantita(btn, user, prodotto, prezzo){
    const modo = btn.text();
    const quantita = btn.parent().find(".quantita");
    let q = parseInt(quantita.text());
    eval(`q ${modo}= 1`);
    btn.parent().find(".meno").attr("disabled", q == 0);
    inviaRichiesta("post", "cambia_quantita.php", { "quantita": q, user, prodotto}).done(function(data){
        btn.parent().find(".piu").attr("disabled", q == data["ok"]);
        quantita.text(q);
        calcolaTotale();
    });

}

function collassa(){
    $(".cella-info").toggleClass("collassa");
}

function calcolaTotale(){
    let tot = 0;
    $(".prodotto").each(function(i, ref){
        const prezzo = $(ref).find(".prezzo-prodotto").text().replace("€", "").replace(",", ".");
        const quantita = $(ref).find(".quantita").text();
        tot += prezzo * quantita;
    });
    $("#totale").text(tot.toFixed(2).replace(".", ",") + "€");

    if(tot == 0){
        $("#info").hide();
        $("#vuoto").removeClass("nascosto");
    }
}

function eliminaProdotto(btn, user, prodotto){
    inviaRichiesta("post", "togli_carrello.php", { user, prodotto}).done(function(data){
        if(data["ok"]){
            btn.parent().remove();
            calcolaTotale();
            mostraConferma(data["ok"])
        }
    });
}

async function ordina(){
    let vuoto = false;
    $("#info input").each(function(i, ref){
        vuoto |= $(ref).val() == "";
    });
    if(vuoto) return mostraErrore("Campi non compilati");
    let user = await inviaRichiesta("GET", "get_user.php");
    user = user["user"];
    if(!user) return mostraErrore("Utente non loggato");
    const prodotti = await inviaRichiesta("GET", "carrello.php", { user });
    
    if(prodotti.length == 0) return mostraErrore("Carrello vuoto");

    inviaRichiesta("POST", "nuovo_ordine.php", { user, prodotti }).done(function(data){
        if(data["id"]){
            window.location.href = "ordine_effettuato.php?id=" + data["id"];
        }
        else mostraErrore("Errore nell'ordine");
    })

}