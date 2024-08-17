<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon.webp">
    <title>Home ・ Ernico</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/home.css"/>
    <!-- SCRIPT LOCALI -->
    <script src="./server/libreria_server.js"></script>
    <script src="js/index.js"></script>
    <script src="js/home.js"></script>
    <script src="js/effetti grafici/home.js"></script>
    <!-- jQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- LENIS -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1/bundled/lenis.min.js"></script>
    <!-- ION-ICONS -->
    <script defer src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- SCROLLTRIGGER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
</head>
<body class="flex-col">
    <div class="cursore nascosto"></div>
    <div class="cursore-dentro nascosto"></div>
    <header class="flex-row jc-c">
        <div class="logo flex-row al-c" onclick="window.location.href = '#'">
            <div>E</div>
            <div>Ernico</div>
        </div>
        <div class="flex-row al-c" id="elenco-header">
            <div class="voce-elenco flex-col jc-c" onclick="scrolla($(this))">Recensioni</div>
            <div class="voce-elenco flex-col jc-c" onclick="scrolla($(this))">Prodotti</div>
            <div class="voce-elenco flex-col jc-c" onclick="scrolla($(this))">Partner</div>
            <div class="voce-elenco flex-col jc-c" onclick="scrolla($(this))">Social</div>
        </div>
        <div id="cont-bottoni" class="flex-row al-c 
                <?php
                    session_start();
                    if(isset($_SESSION['username'])) {
                        echo 'mostra-utente';
                    }
                ?>
            ">
            <button class="btn primario" onclick="window.location.href = './registrazione.php?prec=index'">Registrati</button>
            <button class="btn accento" onclick="window.location.href = './login.php?prec=index'">Accedi</button>
            <span class="hl" id="nome-utente">
                <?php
                    if(isset($_SESSION['username'])){
                        echo $_SESSION['username'];
                    }
                ?>
            </span>
            <ion-icon name="log-out-outline" onclick="logout()"></ion-icon>
        </div>
    </header>
    <section>
        <main>
            <div class="griglia-main">
                <div class="wrapper-griglia">
                    <div class="img-griglia"></div>
                    <div class="blob-griglia"></div>
                </div>
            </div>
            <div class="griglia-main">
                <div class="wrapper-griglia">
                    <div class="img-griglia"></div>
                    <div class="blob-griglia"></div>
                </div>
            </div>
            <div id="wrapper-principale" class="flex-row jc-c al-c">
                <div id="cont-principale" class="flex-col jc-c">
                    <h4>SLOGAN PAZZO</h4>
                    <h1>Tuffati nel <span class="hl">Divertimento</span>,<br/> Emergi <span class="hl">Vincente</span>.</h1>
                    <h3>
                        Esplora mondi incredibili, sfida i tuoi limiti e forma leggende senza fine. 
                    </h3>
                    <button class="btn primario" onclick="$('.voce-elenco').eq(1).click()">
                        Scopri di Più
                    </button>
                </div>
            </div>
        </main>
        <article id="cont-carte" class="flex-row">
            <div class="carta-stat flex-col jc-c al-c">
                <ion-icon name="shield-checkmark-outline"></ion-icon>
                <h6>Sicuro & Affidabile</h6>
            </div>
            <div class="carta-stat flex-col jc-c al-c">
                <ion-icon name="diamond-outline"></ion-icon>    
                <h6>Servizio Premium</h6>
            </div>
            <div class="carta-stat flex-col jc-c al-c">
                <ion-icon name="hardware-chip-outline"></ion-icon>
                <h6>Ultime Tecnologie</h6>
            </div>
            <div class="carta-stat flex-col jc-c al-c">
                <ion-icon name="flash-outline"></ion-icon>
                <h6>Prestazioni Superiori</h6>
            </div>
        </article>
        <div class="cont-freccia flex-col al-c">
            <ion-icon name="chevron-down-outline" onclick="window.scrollTo(0, window.innerHeight)">
            </ion-icon>
        </div>
        <article id="recensioni" class="flex-row jc-c al-c">
            <div class="flex-col">
                <div class="wrapper-griglia">
                    <div class="img-griglia"></div>
                    <div class="blob-griglia"></div>
                </div>
            </div>
            <div class="flex-row wrap jc-c al-c" id="cont-stat">
                <div class="statistica flex-col al-c jc-c">
                    <ion-icon name="star-outline"></ion-icon>
                    <h3>0</h3>
                    <h6>Valutazione Media</h6>
                </div>
                <div class="statistica flex-col al-c jc-c">
                    <ion-icon name="happy-outline"></ion-icon>
                    <h3>1825</h3>
                    <h6>Clienti Soddisfatti</h6>
                </div>
                <div class="statistica flex-col al-c jc-c">
                    <ion-icon name="bag-check-outline"></ion-icon>
                    <h3>0</h3>
                    <h6>Ordini Effettuati</h6>
                </div>
                <div class="statistica flex-col al-c jc-c">
                    <ion-icon name="thumbs-up-outline"></ion-icon>
                    <h3 class="percentuale">0</h3>
                    <h6>Feedback Positivi</h6>
                </div>
            </div>
            <div id="cont-recensioni" class="flex-row">
                <div class="flex-col"></div>
                <div class="flex-col"></div>
            </div>
        </article>
        <article id="prodotti" class="flex-col al-c jc-c">
            <div class="blob-griglia"></div>
            <h1><span class="hl">Eleva</span> il tuo livello di gioco</h1>
            <h3>Scatena il <span class="hl">Potenziale</span> con Mouse, Tastiere, Cuffie <br/>e Accessori da Gaming</h3>
            <div id="cont-categoria" class="flex-row wrap al-c jc-c">
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=mouse'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/mouse.webp)">
                       <div class="wrapper-categoria">
                            <span>
                                <h4>Mouse</h4>
                            </span>
                       </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=tastiere'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/tastiera.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Tastiere</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=monitor'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/monitor.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Monitor</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=mousepad'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/mousepad.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Mousepad</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=cuffie'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/cuffie.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Cuffie</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=microfoni'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/mic.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Microfoni</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=accessori'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/accessori.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Accessori</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="categoria" onclick="window.location.href = './prodotti.php?s=tutto'">
                    <div class="categoria-content" style="background-image: url(./img/categoria/tutto.webp)">
                        <div class="wrapper-categoria">
                            <span>
                                <h4>Tutto</h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <article id="partner" class="flex-col jc-c al-c">
            <div class="blob-griglia"></div>
            <div class="loghi">
                <div class="logo-partner" style="background-image: url(./img/logo/logitech.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/pwnage.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/corsair.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/razer.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/msi.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/rog.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/ss.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/roccat.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/gl.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/cm.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/hyperx.webp)"></div>
                <div class="logo-partner" style="background-image: url(./img/logo/rd.webp)"></div>
            </div>
            <div class="wrapper-partner flex-col jc-c al-">
                <div class="cont-partner flex-col jc-c al-c">
                    <div class="logo-grande">
                        <div>E</div>
                    </div>
                    <h1>I nostri <span class="hl">partner</span></h1>
                    <h3>Per garantirti sempre la <span class="hl">massima</span> qualità</h3>
                </div>
            </div>
        </article>
    </section>
    <footer class="flex-col" id="social">
        <h5>Contattaci</h5>
        <h3>
            <a href="mailto:support@ernico.it">support<span class="hl">@</span>ernico.it</a>
        </h3>
        <div class="flex-row al-c">
            <div>Rimani in conttatto</div>
            <div class="spacer-orizz"></div>
            <ion-icon name="logo-facebook"></ion-icon>
            <ion-icon name="logo-instagram"></ion-icon>
            <ion-icon name="logo-twitter"></ion-icon>
        </div>
        <div class="flex-row sb">
            <div>Via Oscar Milano 188, 12040 Sanfrè CN</div>
            <div>Copyright 2023 ・ 
                <span style="font-family: 'Logo', sans-serif;" class="hl">E</span>
            </div>
        </div>
    </footer>
</body>
</html>
