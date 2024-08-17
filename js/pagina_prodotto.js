
function scriviRecensione(user, prodotto){
    Swal.fire({
        title: 'Aggiungi Recensione',
        showCancelButton: false,
        showCloseButton: true,
        showConfirmButton: false,
        html: `
            <div class="flex-col cont-swal">
                <div class="flex-row jc-c al-c stelle">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star-half"></ion-icon>
                    <ion-icon name="star-outline"></ion-icon>
                </div>
                <div class="cella-input flex-col jc-c">
                    <div class="wrapper-input flex-row">
                    <textarea id="descrizione" placeholder="Descrivici la tua esperienza"></textarea>
                </div>
                <button class="btn accento" disabled id="invia-recensione">Invia</button>
            </div>
        `,
        customClass: {
            popup: 'finestra-swal',
            title: 'titolo-swal',
            htmlContainer: 'wrapper-swal',
        },
        willOpen: (s) => {
            const stelle = $(s).find(".stelle ion-icon")
            stelle.on("click", (e) => {
                const stella = $(e.target)
                const width = stella.width();
                const rect = stella.get(0).getBoundingClientRect();
                const x = e.clientX - rect.left;

                stella.prevAll().prop("name", "star")
                stella.nextAll().prop("name", "star-outline")
                if(x < width/2){
                    stella.prop("name", "star-half")
                }else{
                    stella.prop("name", "star")
                }
            })

            $(s).find("textarea").on("input", (e) => {
                $(s).find("button").prop("disabled", e.target.value.trim() < 10)
            })

            $("#invia-recensione").on("click", (e) => {
                const testo = $(s).find("textarea").val()
                const rating = $(s).find(".stelle ion-icon[name='star']").length + $(s).find(".stelle ion-icon[name='star-half']").length/2;
                console.log(user, prodotto, testo, rating)
                inviaRichiesta("POST", "aggiungi_recensione.php", {user, prodotto, testo, rating}).then((data) => {
                    window.location.reload()
                });
            })
        },
      })
}



function modificaRecensione(user, prodotto, r){
    r = r.closest(".recensione")
    Swal.fire({
        title: 'Aggiungi Recensione',
        showCancelButton: false,
        showCloseButton: true,
        showConfirmButton: false,
        html: `
            <div class="flex-col cont-swal">
                <div class="flex-row jc-c al-c stelle">
                </div>
                <div class="cella-input flex-col jc-c">
                    <div class="wrapper-input flex-row">
                    <textarea id="descrizione" placeholder="Descrivici la tua esperienza"></textarea>
                </div>
                <button class="btn accento" id="invia-recensione">Modifica</button>
                <button class="btn primario" id="elimina-recensione">Elimina</button>
            </div>
        `,
        customClass: {
            popup: 'finestra-swal',
            title: 'titolo-swal',
            htmlContainer: 'wrapper-swal',
        },
        willOpen: (s) => {
            r.find(".stelle ion-icon").clone().appendTo($(s).find(".stelle"))

            const stelle = $(s).find(".stelle ion-icon")
            stelle.on("click", (e) => {
                const stella = $(e.target)
                const width = stella.width();
                const rect = stella.get(0).getBoundingClientRect();
                const x = e.clientX - rect.left;

                stella.prevAll().prop("name", "star")
                stella.nextAll().prop("name", "star-outline")
                if(x < width/2){
                    stella.prop("name", "star-half")
                }else{
                    stella.prop("name", "star")
                }
            })

            $(s).find("textarea").on("input", (e) => {
                $(s).find("button").prop("disabled", e.target.value.trim() < 10)
            }).val(r.find("p").text())

            $("#invia-recensione").on("click", (e) => {
                const testo = $(s).find("textarea").val()
                const rating = $(s).find(".stelle ion-icon[name='star']").length + $(s).find(".stelle ion-icon[name='star-half']").length/2;
                console.log(user, prodotto, testo, rating)
                inviaRichiesta("POST", "aggiungi_recensione.php", {user, prodotto, testo, rating}).then((data) => {
                    window.location.reload()
                });
            })
            $("#elimina-recensione").on("click", (e) => {
                inviaRichiesta("POST", "elimina_recensione.php", {user, prodotto}).then((data) => {
                    window.location.reload()
                })
            })
        },
      })
}

async function carrello(prodotto){
    console.log("ciao")
    try{
        const user = await inviaRichiesta("Get", "get_user.php", {})
        inviaRichiesta("POST", "aggiungi_carrello.php", {prodotto, user: user['user']}).then((data) => {
            if(data["ok"]){
                mostraConferma(data["ok"])
                $("#carrello").addClass("aggiunto").prop("disabled", true).text("Aggiunto")
            }
        })
    }catch(err){
        window.location.href = "login.php"
    };
    
}