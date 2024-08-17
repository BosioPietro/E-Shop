'use strict'

const c = console.log

window.addEventListener("load", () => {
    $(".btn-mostra").appendTo("section")
})


// doppio slider
window.addEventListener("load", () => {
    const rangeMin = 5;
    const range = $(".range-selected");
    const rangeInput = $(".range-input input");
    const rangePrice = $("#cont-prezzo input");
    const prezzoMinimo = parseInt($(".range input").attr("min"));

    rangeInput.each((i, input) => {
        $(input).on("input", (e) => {
            let minRange = parseInt(rangeInput.eq(0).val());
            let maxRange = parseInt(rangeInput.eq(1).val());
            if (maxRange - minRange < rangeMin) {     
                if ($(e.target).hasClass("min"))
                {
                    rangeInput.eq(0).val(maxRange - rangeMin);        
                } 
                else  rangeInput.eq(1).val(minRange + rangeMin);        
            } else {
                
                rangePrice.eq(0).val(minRange);
                rangePrice.eq(1).val(maxRange);
                range.css({left : `${(minRange - prezzoMinimo) / (rangeInput.eq(0).attr("max") - prezzoMinimo ) * 100}%`});
                range.css({right : `${100 - ((maxRange - prezzoMinimo) / ( rangeInput.eq(1).attr("max") - prezzoMinimo )) * 100}%`});
            }
        });
    });

    rangePrice.each((i, input) => {
        input.addEventListener("input", (e) => {
            let minPrice = rangePrice.eq(0).val();
            let maxPrice = rangePrice.eq(1).val();
            const cont = $(e.target)
            let valore = parseInt(cont.val());
            cont.val(valore);
            if(isNaN(valore))
            {
                if(cont.hasClass("min")){
                    minPrice = 0;
                    cont.val(minPrice);
                }
                else{
                    maxPrice = parseInt(rangeInput.eq(1).attr("max"));
                    cont.val(maxPrice);
                }
            }
            
            if (maxPrice - minPrice >= rangeMin && maxPrice <= parseInt(rangeInput.eq(1).attr("max"))) {
                if (cont.hasClass("min")) {
                    rangeInput.eq(0).val(minPrice);
                    range.css({left : `${(minPrice / rangeInput.eq(0).attr("max")) * 100}%`});
                } else {
                    rangeInput.eq(1).val(maxPrice);
                    range.css({right : 100 - (maxPrice / rangeInput[1].max) * 100 + "%"});
                }
            } 
        });
    });
    rangeInput.trigger("input");
})

function vaiA(dove){
    const params = ottieniParametri(window.location.search)
    window.location.href = `${dove}.php?prec=prodotti&${$.param(params)}`
}

function cambiaCat(chk){
    const cat = chk.val();
    if(cat == "tutto"){
        $("#cont-cat input").not(chk).prop("checked", false)
    }
    else{
        $("#cont-cat input[value='tutto']").prop("checked", false)
    }
}

function applicaFiltri(){
    const filtri = {}
    filtri["prezzoMin"] = $("#prezzo-min").val()
    filtri["prezzoMax"] = $("#prezzo-max").val()
    filtri["prezzo-enabled"] = $("#chk-prezzo").prop("checked")
    filtri["marca-enabled"] = $("#chk-marca").prop("checked")
    filtri["marca"] = []
    $("#cont-marche input:checked").each((i, chk) => {
        filtri["marca"].push(chk.value)
    })
    filtri["categoria"] = []
    $("#cont-cat input:checked").each((i, chk) => {
        filtri["categoria"].push(chk.value)
        console.log(i)
    })
    console.log($.param(filtri))
    window.location.href = `prodotti.php?${$.param(filtri)}`
}