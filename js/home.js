'use strict'

// Stampa le recensioni

window.addEventListener("load", () => {
    stampaRecensioni()
    stampaRecensioni()
    function stampaRecensioni(){
        $("#cont-recensioni > .flex-col").each((i, e) => {
            for(let i = 0; i < 10; i++){
                const recensione = `
                <div class="recensione flex-col jc-c">
                    <div class="flex-row nome jc-c wrap">
                    <ion-icon name="person-circle-outline"></ion-icon>
                        <div class="flex-col" style="justify-content: space-between">
                            <h6>Nome Cognome ${i}</h6>
                            <div class="flex-row al-c stelle">
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-half"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
                </div>`
                $(e).append(recensione)
            }
        })
    }
})

// piazza i loghi in cerchio

window.addEventListener("load", () => {
    const N_LOGHI = 12;
    const GRAND = $(".logo-partner").css("--grandezza")
    const RAGGIO = remInPx($(".loghi").css("--raggio"))

    $(".logo-partner").each((i, e) => {
        const {x, y} = coordinataCerchio(RAGGIO, 2 * Math.PI / N_LOGHI, i)
        $(e).css({
            top: `calc(50% + ${y}rem - ${GRAND} / 2)`,
            left: `calc(50% + ${x}rem - ${GRAND} / 2)`
        })
    })

    function coordinataCerchio(raggio, angolo, indice) {
        const x = (raggio * Math.cos(angolo * indice)).toFixed(2)
        const y = (raggio * Math.sin(angolo * indice)).toFixed(2)
        return {x, y}
    }
})

