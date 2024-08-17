<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    $id = null;
    if(isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
    }
    else die("<script>window.location.href = './prodotti.php'</script>");
    require("./server/MySQLi.php");
    $conn = openConnection("ernico");
    $query = "SELECT * FROM prodotti WHERE id = $id";

    $p = eseguiQuery($conn, $query)[0];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon.webp">
    <title>
        <?php
            echo($p["nome"]." ・ Ernico");
        ?>
    </title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/pagina_prodotto.css"/>
    <!-- SCRIPT LOCALI -->
    <script src="server/libreria_server.js"></script>
    <script src="js/index.js"></script>
    <script src="js/pagina_prodotto.js"></script>
    <script src="js/effetti grafici/pagina_prodotto.js"></script>
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
            <div class="voce-elenco flex-col jc-c" onclick="window.location.href = './checkout.php'">Carrello</div>
            <div class="voce-elenco flex-col jc-c"  onclick="scrolla($(this))">Social</div>
        </div>
        <div id="cont-bottoni" class="flex-row al-c 
                <?php
                    if(isset($_SESSION['username'])) {
                        echo 'mostra-utente';
                    }
                ?>
            ">
            <button class="btn primario" onclick="window.location.href = './registrazione.php?prec=pagina_prodotto'">Registrati</button>
            <button class="btn accento" onclick="window.location.href = './login.php?prec=pagina_prodotto'">Accedi</button>
            <span class="hl" id="nome-utente">
                <?php
                    if(isset($_SESSION['username'])){
                        echo $_SESSION['username'];
                    }
                    $user_id = null;
                    if(isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                    }
                ?>
            </span>
            <ion-icon name="log-out-outline" onclick="logout()"></ion-icon>
        </div>
    </header>
    <section>
        <article id="prodotto" class="flex-row">
            <img src="<?php echo("./img_prodotti/$p[categoria]/$p[id].png")?>">
            <div id="descrizione" class="flex-col al-c jc-c grow">
                <div id="titolo"><?php echo($p["nome"])?></div>
                <div id="rating" class="flex-row jc-c al-c">
                    <div class="flex-row al-c stelle">
                        <?php
                            $query = "SELECT COUNT(*) AS numero FROM recensioni WHERE prodotto = $id";
                            $numero = eseguiQuery($conn, $query)[0]["numero"];
                            $query = "SELECT AVG(rating) AS rating FROM recensioni WHERE prodotto = $id";
                            $p["rating"] = eseguiQuery($conn, $query)[0]["rating"];
                            $p["rating"] = number_format($p["rating"], 1);
                            if($numero > 0)
                            {
                                $intero = floor($p["rating"]);
                                $decimale = 0;
                                if($intero != $p["rating"])
                                {
                                    $decimale = 1;
                                }
                                for($i = 0; $i < $intero; $i++)
                                {
                                    echo('<ion-icon name="star"></ion-icon>');
                                }
                                if($decimale == 1)
                                {
                                    echo('<ion-icon name="star-half"></ion-icon>');
                                }
                                for($i = 0; $i < 5 - $intero - $decimale; $i++)
                                {
                                    echo('<ion-icon name="star-outline"></ion-icon>');
                                }
                            }
                        ?>
                    </div>
                    <?php
                        if($numero > 0){
                            echo("<p> ・ </p>");
                        }
                    ?>
                    <div id="link-recensioni" onclick="scrolla(null, 'recensioni')">
                        <?php
                            $query = "SELECT COUNT(*) AS numero FROM recensioni WHERE prodotto = $id";
                            $numero = eseguiQuery($conn, $query)[0]["numero"];

                            if($numero == 0)
                            {
                                echo("Nessuna recensione");
                            }
                            else if($numero == 1)
                            {
                                echo("1 recensione");
                            }
                            else
                            {
                                echo("$numero recensioni");
                            }
                        ?>
                    </div>
                </div>
                <h2 id="prezzo">
                    <?php
                        $prezzo = $p["prezzo"] * (100 - $p["sconto"]) / 100;
                        echo(number_format($prezzo, 2)."€")
                    ?>
                <span>IVA inclusa</span></h2>
                <?php
                    if($p["sconto"] != 0)
                    {
                        echo("<h3 id='precedente'>Prima era: <s>$p[prezzo] €</s> (<span>-$p[sconto]%</span>)</h3>");
                    }
                    
                    if($p["quantita"] == 0)
                    {
                        echo('<span class="flex-row"><ion-icon class="non-disp" name="close-circle-outline"></ion-icon>
                        <h4 class="non-disp">Non disponibile</h4></span>');
                        
                    }
                    else
                    {
                        echo('<div id="spedizione" class="flex-row">'.
                            '<ion-icon name="checkmark-outline"></ion-icon>'.
                            '<span>Spedizione veloce disponbile</span>'.
                        '</div>');
                        $carrello = null;
                        if($user_id != null){
                            $query = "SELECT * FROM carrello WHERE user = $user_id AND prodotto = $id";
                            $carrello = eseguiQuery($conn, $query);
                        }
                        if($carrello != null && count($carrello) > 0)
                        {
                            echo('<button class="btn accento aggiunto" id="carrello" disabled>Aggiunto</button>');
                        }
                        else
                        {
                            echo('<button class="btn accento" id="carrello" onclick="carrello('.$id.','.$user_id.')">Aggiungi al carrello</button>');
                        }

                    }
                ?>
                
               
            </div>
        </article>
        <article id="specifiche" class="flex-col jc-c al-c">
            <h1>Specifiche Tecniche</h1>
            <div class="table">
                <?php
                    echo "<div class='td'>
                            <div class='td-content'>Marca</div>
                        </div>".
                        "<div class='td'>
                            <div class='td-content'>$p[marca]</div>
                        </div>";
                    
                    $spec = json_decode($p["specifiche"], true);
                    if($spec != null)
                    foreach($spec as $indice => $s)
                    {
                        echo "<div class='td'>
                            <div class='td-content'>$indice</div>
                        </div>".
                        "<div class='td'>
                            <div class='td-content'>$s</div>
                        </div>";
                    }
                ?>
            </div>
        </article>
        <article id="recensioni" class="flex-col jc-c al-c wrap">
            <h1>Recensioni Prodotto</h1>
            <?php
                $query = "SELECT * FROM recensioni WHERE prodotto = $id";
                $recensioni = eseguiQuery($conn, $query);
                if(count($recensioni) == 0)
                {
                    echo('<div id="no-recensioni" class="flex-col jc-c al-c">
                            <h2>Non ci sono recensioni per questo prodotto</h2>');
                    if($user_id != null){
                        echo('<button class="btn accento" onclick="scriviRecensione('.$user_id.','.$p["id"].')">Scrivi una recensione</button>');
                    }else{
                        echo('<button class="btn accento" onclick="window.location.href = \'./login.php?prec=pagina_prodotto&id='.$p["id"].'\'">Scrivi una recensione</button>');
                    }
                    echo('</div>');
                }else{
                    if($user_id != null){
                        echo('<button class="btn accento" onclick="scriviRecensione('.$user_id.','.$p["id"].')">Scrivi una recensione</button>');
                    }else{
                        echo('<button class="btn accento" onclick="window.location.href = \'./login.php?prec=pagina_prodotto&id='.$p["id"].'\'">Scrivi una recensione</button>');
                    }
                    foreach($recensioni as $r){
                        $query = "SELECT * FROM utenti WHERE id = $r[user]";
                        $u = eseguiQuery($conn, $query)[0];
                        echo(
                        '<div class="recensione flex-col jc-c">
                        <div class="flex-row nome jc-c wrap al-c">
                        <ion-icon name="person-circle-outline"></ion-icon>
                            <div class="flex-col" style="justify-content: space-between">
                                <h6>'.$u["username"].'</h6>
                                <div class="flex-row al-c stelle">');
                                $intero = floor($r["rating"]);
                                $decimale = 0;
                                if($intero != $r["rating"])
                                {
                                    $decimale = 1;
                                }
                                for($i = 0; $i < $intero; $i++)
                                {
                                    echo('<ion-icon name="star"></ion-icon>');
                                }
                                if($decimale == 1)
                                {
                                    echo('<ion-icon name="star-half"></ion-icon>');
                                }
                                for($i = 0; $i < 5 - $intero - $decimale; $i++)
                                {
                                    echo('<ion-icon name="star-outline"></ion-icon>');
                                }
                        echo('</div></div>');
                        if($r["user"] == $user_id)
                        {
                            echo('&nbsp;<ion-icon name="pencil" onclick="modificaRecensione('.$user_id.','.$p["id"].',$(this))" id="modifica"></ion-icon>');
                        }
                        echo('</div>
                            <p>'.$r["testo"].'</p>
                            </div>');
                    }
                }
            ?>
        </article>
    </section>
    <footer class="flex-col" id="social">
        <h5>Contattaci</h5>
        <h3><a href="mailto:support@ernico.it">support<span class="hl">@</span>ernico.it</a></h3>
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
