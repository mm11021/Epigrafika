<?php

include 'dictionary.php';

function unesi($data, $db){

//    $db=konekcija::getConnectionInstance();

    $data = json_decode($data);

    $oznaka = $data->oznaka;
    $oznaka=mysql_real_escape_string($oznaka);
    $natpis = $data->natpis;
    $natpis=mysql_real_escape_string($natpis);

    /*dobijamo ime jezika pa spajamo sa bazom da bismo dobili id */
    $jezikUpisa = $data->jezikUpisa;
    $query="SELECT id FROM `Jezik` WHERE naziv=:jezik";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":jezik", $jezikUpisa, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $jezikUpisa= $o[0][0];


    //Potrebno je odrediti id vrsteNatpisa
    $vrstaNatpisa = $data->vrstaNatpisa;
    $query="SELECT id FROM `Vrstanatpisa` WHERE naziv=:vrstaNatpisa";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":vrstaNatpisa", trim($vrstaNatpisa), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $vrstaNatpisa=$o[0][0];

    //u vezi null-a ako nece da prodje prosledjen null, mozemo da stavimo if(null) stavljamo 0

    $lokalizovanPodatak = $data->LokalizovanPodatak;
    //echo "<br>Lokalizovan: $lokalizovanPodatak";
    if($lokalizovanPodatak==true){
        $provincija = $data->provincija;
        $grad = $data->grad;

        $mestoNalaska = trim($data->mestoNalaska);
        $query = "select count(*) from Mesto where naziv=:mestoNalaska";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":mestoNalaska", $mestoNalaska, PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $brojMesta = $o[0][0];

        if($brojMesta == 0){
            $query = "insert into Mesto (naziv) values(:mestoNalaska)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":mestoNalaska", $mestoNalaska, PDO::PARAM_STR);
            $stmt->execute();

        }

        //Potrebno je odrediti id Mesta
        $query="SELECT id FROM `Mesto` WHERE naziv=:mesto";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":mesto", trim($mestoNalaska), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $mestoNalaska=$o[0][0];



        //Potrebno je odrediti id provincije
        $query="SELECT id FROM `Provincija` WHERE naziv=:provincija";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":provincija", trim($provincija), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $provincija=$o[0][0];
        //Potrebno je odrediti id grada
        $query="SELECT id FROM `Grad` WHERE naziv=:grad";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":grad", trim($grad), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $grad=$o[0][0];
//            echo "<br>Id grada: ".$o[0][0];


    }
    else{


        $provincija = -1;
        $grad = -1;
        $mestoNalaska = -1;

    }



    $modernoImeDrzave = $data->modernoImeDrzave;
    //Potrebno je odrediti id moderneDrzave
    $query="SELECT id FROM `ModernaDrzava` WHERE naziv=:modernaDrzava";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":modernaDrzava", trim($modernoImeDrzave), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $modernoImeDrzave=$o[0][0];
//        echo "<br>Id moderne Drzave: ".$o[0][0];
    //Potrebno je odrediti id modernogMesta
    $modernoMesto = $data->modernoMesto;
    $query="SELECT id FROM `ModernoMesto` WHERE naziv=:modernoMesto";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":modernoMesto", trim($modernoMesto), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $modernoMesto =$o[0][0];
//        echo "<br>Id modernog mesta: ".$o[0][0];

    $trenutnaLokacijaZnamenitosti = $data->trenutnaLokacijaZnamenitosti;
    $trenutnaLokacijaZnamenitosti=mysql_real_escape_string($trenutnaLokacijaZnamenitosti);

    $query="SELECT count(*) FROM `Ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();


    if($o[0][0]==0){
//        $trenutnaLokacijaZnamenitosti = -1;
        $trenutnoModernoMesto = -1;
        $query="INSERT INTO  `Ustanova` (naziv, modernoMesto) VALUES (:trenutnaLokacijaZnamenitosti, :trenutnoModernoMesto)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
        $stmt->bindParam(":trenutnoModernoMesto", $trenutnoModernoMesto, PDO::PARAM_INT);
        $stmt->execute();


    }
    $query = "SELECT id FROM `Ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $trenutnaLokacijaZnamenitosti = $o[0][0];


//Potrebno je odrediti id plemena
    $pleme = $data->pleme;
    $pleme=mysql_real_escape_string($pleme);

    $query="SELECT count(*) FROM `Pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();

    if($o[0][0]==0) {

        $query="INSERT INTO  `Pleme` (naziv) VALUES (:pleme)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
        $stmt->execute();

    }
    $query = "SELECT id FROM `Pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $pleme = $o[0][0];

//        echo "<br>Id plemena: ".$o[0][0];

//        radimo sa vremenom, dovrsiti
    $vreme = $data->vreme;

    if(strcmp($vreme, "nedatovan")==0){
        $datovano = false;

        $pocetakGodina = null;
        $pocetakVek = null;
        $pocetakOdrednica = null;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;

    }
    //velika mogucnost greske

    else if(strcmp($vreme, "godina")==0){
        $datovano = true;
        $pocetakGodina = $data->godinaPronalaska;
        $pocetakVek = $data->vekGodine;
        $pocetakOdrednica = $data->periodVekGodine;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;

    }

    else if(strcmp($vreme, "unosVeka")==0){

        $datovano = true;
        $pocetakGodina = null;
        $pocetakVek = $data->vekPronalaska;
        $pocetakOdrednica = $data->periodVeka;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;
    }

    else if(strcmp($vreme, "unosPeriodaOdDo")==0){
        $datovano = true;
        $pocetakGodina = $data->pocetakGodina;
        $pocetakVek = $data->pocetakVek;
        $pocetakOdrednica = $data->pocetakPeriodVeka;
        $krajGodina = $data->krajGodina;
        $krajVek = $data->krajVek;
        $krajOdrednica = $data->krajPeriodVeka;

    }

// datum kreiranja, datum poslednje izmene

    $datumKreiranja=date("Y-m-d");
    $datumPoslednjeIzmene=date("Y-m-d");

//       faza unosa
    $fazaUnosa = $data->fazaUnosa;

    //tip i ostalo
    $tip = $data->tipZnamenitosti;
    $materijal = $data->materijalZnamenitosti;
    $komentar = $data->komentar;

    $tip=mysql_real_escape_string($tip);
    $materijal=mysql_real_escape_string($materijal);
    $komentar=mysql_real_escape_string($komentar);

    //dimenzije objekta, trenutno nemamo format, prepraviti
    $dimenzije = $data->sirina;
    $dimenzije.= ':';
    $dimenzije.=$data->visina;
    $dimenzije.= ':';
    $dimenzije.=$data->duzina;
    $korisnickoIme=$data->korisnickoIme;

    // Unos bibliografskog podatka- priprema

    $bibliografskoPoreklo=$data->bibliografskoPoreklo;
    $bibliografskoPorekloSkracenica=$data->bibliografskoPorekloSkracenica;
    $bibliografskiPdfLinkovi=$data->bibliografskiPdfLinkovi;




    // izdvojiti url iz url/path
    // ovime cu dobiti url/
    if(count($data->bibliografskiPdfLinkovi)) {
        $url = $data->bibliografskiPdfLinkovi[0];

        $arr = explode('/', $url);

        $length = count($arr);

        $url = '';

        for ($i = 0; $i < $length - 1; $i++)
            $url .= $arr[$i] . '/';


        $putanja = $bibliografskiPdfLinkovi[0];
    }else $url='';


    // sada vrsimo unos u tabelu bibliografski podatak
    $query="INSERT INTO `BibliografskiPodatak` (skracenica, naslov, putanja) VALUES (:skracenica, :naslov, :putanja)";
    $stmt=$db->prepare($query);
    $returnValue=$stmt->execute(array(':skracenica'=>$bibliografskoPorekloSkracenica, ':naslov'=>$bibliografskoPoreklo, 'putanja'=>$url));


    // pripremanje vrednosti za Izvod Bibliografskog Podatka

    // objekat

    $query="SELECT max(id) FROM `Objekat` WHERE 1";
    $stmt=$db->prepare($query);
    $returnValue=$stmt->execute();
    $obj=$stmt->fetchAll();
    $obj=$obj[0][0]+1;

    // bibliografski podatak

    $query="SELECT max(id) FROM `BibliografskiPodatak` WHERE 1";
    $stmt=$db->prepare($query);
    $returnValue=$stmt->execute();
    $bibl=$stmt->fetchAll();
    $bibl=$bibl[0][0];

    // prvo se mora izvrsiti insert za tabelu Objekat

    $query="INSERT INTO Objekat(oznaka, jezik, tekstNatpisa, vrstaNatpisa, provincija,
        grad, mesto, modernaDrzava,modernoMesto, tip, materijal, dimenzije, komentar, datumKreiranja,
        datumPoslednjeIzmene, faza, pleme, ustanova, korisnickoIme, lokalizovano, datovano,
        pocetakGodina, pocetakVek, pocetakOdrednica, krajGodina, krajVek, krajOdrednica)
         VALUES (:oznaka, :jezikUpisa, :natpis, :vrstaNatpisa, :provincija,
         :grad, :mestoNalaska, :modernoImeDrzave,:modernoMesto, :tip, :materijal, :dimenzije, :komentar, :datumKreiranja,
         :datumPoslednjeIzmene, :fazaUnosa, :pleme, :trenutnaLokacijaZnamenitosti, :korisnickoIme, :lokalizovanPodatak,
         :datovano, :pocetakGodina, :pocetakVek, :pocetakOdrednica, :krajGodina, :krajVek, :krajOdrednica)";

    populateDictionary($natpis);

    $stmt = $db->prepare($query);
    $returnValue = $stmt->execute(array(':oznaka' => $oznaka, ':jezikUpisa' => $jezikUpisa, ':natpis' => $natpis, ':vrstaNatpisa' => $vrstaNatpisa,
        ':provincija' => $provincija, ':grad' => $grad, ':mestoNalaska' => $mestoNalaska, ':modernoImeDrzave' => $modernoImeDrzave,
        ':modernoMesto' => $modernoMesto, ':tip' => $tip, ':materijal' => $materijal, ':dimenzije' => $dimenzije, ':komentar' => $komentar,
        ':datumKreiranja' => $datumKreiranja, ':datumPoslednjeIzmene' => $datumPoslednjeIzmene, ':fazaUnosa' => $fazaUnosa, ':pleme' => $pleme,
        ':trenutnaLokacijaZnamenitosti'=>$trenutnaLokacijaZnamenitosti, ':korisnickoIme' => $korisnickoIme, ':lokalizovanPodatak'=>$lokalizovanPodatak,
        ':datovano' => $datovano, ':pocetakGodina' => $pocetakGodina, ':pocetakVek' => $pocetakVek, ':pocetakOdrednica' => $pocetakOdrednica,
        ':krajGodina' => $krajGodina, ':krajVek' => $krajVek, ':krajOdrednica' => $krajOdrednica));

    // sada vrsimo pripremu za unos u tabelu Izvod bibliografskog podatka

    for($i=0;$i<count($data->bibliografskiPdfLinkovi);$i++) {

        // odredjujem broj strane
        $query = "SELECT count(*) FROM `IzvodBibliografskogPodatka` WHERE objekat=:objekat AND bibliografskiPodatak=:bibliografskiPodatak";
        $stmt = $db->prepare($query);
        $returnValue = $stmt->execute(array(':objekat'=>$obj, ':bibliografskiPodatak'=>$bibl));
        $strana = $stmt->fetchAll();
        $strana = intval($strana[0][0]) + 1;


        // odredjujemo path iz url/path

        $path=$data->bibliografskiPdfLinkovi[$i];

        $arr=explode('/',$path);
        $path=$arr[count($arr)-1];


        $query="INSERT INTO `IzvodBibliografskogPodatka` (objekat, bibliografskiPodatak, strana, putanja)
        VALUES (:objekat, :bibliografskiPodatak, :strana, :putanja)";
        $stmt=$db->prepare($query);
        $returnValue=$stmt->execute(array(':objekat'=>$obj, ':bibliografskiPodatak'=>$bibl, ':strana'=>$strana, ':putanja'=>$path));


    }

    // sada vrsimo unos i fotografija

    $fotografije=$data->fotografije;


    if(count($data->fotografije)) {
        $url = $data->fotografije[0];

        $arr = explode('/', $url);

        $length = count($arr);

        $url = '';

        for ($i = 0; $i < $length - 1; $i++)
            $url .= $arr[$i] . '/';


        $putanja = $bibliografskiPdfLinkovi[0];


        for($i=0;$i<count($data->fotografije);$i++) {

            // odredjujemo path iz url/path

            $path=$data->fotografije[$i];

            $arr=explode('/',$path);
            $path=$arr[count($arr)-1];


            $query="INSERT INTO `Fotografija` (naziv, putanja, objekat)
        VALUES (:naziv, :putanja, :objekat)";
            $stmt=$db->prepare($query);
            $returnValue=$stmt->execute(array(':naziv'=>$path, ':putanja'=>$url, ':objekat'=>$obj));


        }

    }


    return $returnValue;
}