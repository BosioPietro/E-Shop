<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon.webp">
    <title>Checkout ・ Ernico</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/checkout.css"/>
    <!-- SCRIPT LOCALI -->
    <script src="server/libreria_server.js"></script>
    <script src="js/index.js"></script>
    <script src="js/checkout.js"></script>
    <script src="js/effetti grafici/checkout.js"></script>
    <!-- jQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- LENIS -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1/bundled/lenis.min.js"></script>
    <!-- SWAL -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ION-ICONS -->
    <script defer src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- SCROLLTRIGGER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
</head>
<body class="flex-col">
    <div class="blob-griglia"></div>
    <div class="cursore nascosto"></div>
    <div class="cursore-dentro nascosto"></div>
    <header class="flex-row jc-c">
        <div class="logo flex-row al-c" onclick="window.location.href = './index.php'">
            <div>E</div>
            <div>Ernico</div>
        </div>
        <div class="flex-row al-c" id="elenco-header">
            <div class="voce-elenco flex-col jc-c"  onclick="window.location.href = './index.php'">Home</div>
            <div class="voce-elenco flex-col jc-c" onclick="window.location.href = './prodotti.php'">Prodotti</div>
            <div class="voce-elenco flex-col jc-c"  onclick="scrolla($(this))">Social</div>
        </div>
        <div id="cont-bottoni" class="flex-row al-c 
                <?php
                    session_start();
                    if(isset($_SESSION['username'])) {
                        echo 'mostra-utente';
                    }
                ?>
            ">
            <?php 
                if(!isset($_SESSION['username'])) {
                    die("<script>window.location.href = './login.php?prec=checkout'</script>");
                }
            ?>
            <button class="btn primario" onclick="window.location.href = './registrazione.php?prec=checkout'">Registrati</button>
            <button class="btn accento" onclick="window.location.href = './login.php?prec=checkout'">Accedi</button>
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
    <section class="flex-row">
        <div id="prodotti" class="flex-col grow">
            <h2>Carrello & Checkout</h2>
            <div id="cont-prodotti" class="grow">
                    <?php
                        require('./server/MySQLi.php');
                        $conn = openConnection("ernico");
                        $query = "SELECT p.*, c.quantita as quantita_carrello FROM carrello as c, prodotti as p WHERE c.user = $_SESSION[user_id] AND c.prodotto = p.id";
                        $data = eseguiQuery($conn, $query);
                        $totale = 0;
                        $vuoto = "";
                        if(count($data) > 0){
                            $vuoto = "nascosto";
                        }
                        foreach($data as $p){
                            $prezzo = $p["prezzo"] * (100 - $p["sconto"]) / 100;
                            $totale += $prezzo * $p["quantita_carrello"];
                            $disabled_piu = "";
                            $disabled_meno = "";

                            if($p["quantita_carrello"] >= $p["quantita"]){
                                $p["quantita_carrello"] = $p["quantita"];
                            }

                            if($p["quantita_carrello"] >= $p["quantita"]){
                                $disabled_piu = "disabled";
                            }
                            if($p["quantita_carrello"] == 0){
                                $disabled_meno = "disabled";
                            }
                            echo('<div class="prodotto flex-row al-c jc-sb">
                            <img class="img-prodotto" src="img_prodotti/'.$p["categoria"].'/'.$p["id"].'.png">
                            <div class="nome">'.$p["nome"].'</div>
                            <div class="flex-row al-c">
                                <button class="meno" onclick="cambiaQuantita($(this),'.$_SESSION["user_id"].','.$p["id"].','.$prezzo.')" '.$disabled_meno.'>-</button>
                                <div class="quantita flex-col jc-c al-c">'.$p["quantita_carrello"].'</div>
                                <button class="piu" onclick="cambiaQuantita($(this),'.$_SESSION["user_id"].','.$p["id"].','.$prezzo.')" '.$disabled_piu.'>+</button>
                            </div>
                            <div class="flex-col">
                                <div class="prezzo-prodotto">'.number_format($prezzo, 2, ',').'€</div>
                                <div class="sconto">-'.$p["sconto"].'%</div>
                            </div>
                            <ion-icon name="close-outline" class="trash" onclick="eliminaProdotto($(this),'.$_SESSION["user_id"].','.$p["id"].')"></ion-icon>
                        </div>');
                        }
                    ?>
                    <h3 id='vuoto' class='hl <?php echo $vuoto ?>'>Il carrello è vuoto</h3>
            </div>
            <nav class="flex-row al-c jc-sb">
                <a class="flex-row al-c" href="./prodotti.php">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Torna ai prodotti
                </a>
                <div class="flex-row al-c">
                    <span>Totale:</span>
                    <div id="totale">&nbsp;<?php echo number_format($totale, 2, ',') ?>€</div>
                </div>
            </nav>
        </div>
        <?php
            if($vuoto == ""){
                $vuoto = "nascosto";
            }
            else $vuoto = "";
        ?>
        <div id="info" class="flex-col jc-c al-c <?php echo $vuoto ?>">
            <div class="cella-info flex-col">
                <h2>Spedizione</h2>
                <div class="cella-input flex-col jc-c">
                    <label for="nome">Nome Completo</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="nome" id="nome">
                    </div>
                </div>
                <div class="cella-input flex-col jc-c">
                    <label for="tel">Numero di telefono</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="tel" id="tel">
                    </div>
                </div>
                <div class="cella-input flex-col jc-c">
                    <label for="indirizzo">Indirizzo</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="indirizzo" id="indirizzo">
                    </div>
                </div>
                <div class="cella-input flex-col jc-c">
                    <label for="citta">Città</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="citta" id="citta">
                    </div>
                </div>
                <div class="flex-row">
                    <div class="cella-input flex-col jc-c">
                        <label for="cap">Cap</label>
                        <div class="wrapper-input flex-row">
                            <input type="text" name="cap" id="cap">
                        </div>
                    </div>
                    <div class="cella-input flex-col jc-c">
                        <label for="provincia">Provincia</label>
                        <div class="wrapper-input flex-row">
                            <input type="text" name="provincia" id="provincia">
                        </div>
                    </div>
                </div>
                <button class="btn accento flex-row al-c jc-c" onclick="collassa()">
                    Pagamento
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </button>
            </div>
            <div class="cella-info flex-col collassa">
                <h2>Pagamento</h2>
                <div class="cella-input flex-col jc-c">
                    <label for="numero">Numero Carta</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="numero" id="numero">
                    </div>
                </div>
                <div class="cella-input flex-col jc-c">
                    <div class="wrapper-input flex-col data jc-sb">
                        <label for="mese">Data di Scadenza</label>
                        <div class="flex-row wrapper-data">
                            <div class="flex-col">
                                <label for="mese" class="sotto-label">Mese</label>
                                <input type="text" name="mese" id="mese">
                            </div>
                            <span>/</span>
                            <div class="flex-col">
                                <label for="anno" class="sotto-label">Anno</label>
                                <input type="text" name="anno" id="anno">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cella-input flex-col jc-c">
                    <label for="cvv">CVV</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="cvv" id="cvv">
                    </div>
                </div>
                <button class="btn accento" onclick="ordina()">
                    Conferma & Ordina
                </button>
                <button class="btn accento flex-row al-c jc-c" onclick="collassa()">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Spedizione
                </button>
            </div>
        </div>
    </section>
</body>
</html>
