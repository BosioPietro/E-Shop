

window.addEventListener("load", () => {
    $(window).on("mousemove", (e) => {
        const blob = $(".blob-griglia");
        const x = e.clientX, y = e.clientY;
        let grandezza = parseInt($(".blob-griglia").css("--grandezza"));

        grandezza = remInPx(grandezza);
        blob.css({top : `${y - grandezza / 2 - top}px`, left : `${x - grandezza / 2}px`})
    })
})
