<?php

class TCMB_Kurlar
{
    public $USD; // ABD DOLARI
    public $AUD; // AVUSTRALYA DOLARI
    public $DKK; // DANİMARKA KRONU
    public $EUR; // EURO
    public $GBP; // İNGİLİZ STERLİNİ
    public $CHF; // İSVİÇRE FRANGI
    public $SEK; // İSVEÇ KRONU
    public $CAD; // KANADA DOLARI
    public $KWD; // KUVEYT DİNARI
    public $NOK; // NORVEÇ KRONU
    public $SAR; // SUUDİ ARABİSTAN RİYALİ
    public $JPY; // JAPON YENİ
    public $BGN; // BULGAR LEVASI
    public $RON; // RUMEN LEYİ
    public $RUB; // RUS RUBLESİ
    public $IRR; // İRAN RİYALİ
    public $CNY; // ÇİN YUANI
    public $PKR; // PAKİSTAN RUPİSİ

    private $xml; // xml
    private $attributes; // xml attributes
    private $xmlStatus;

    private $dovizKodlari;
    private $alanlar;

    private $currencies;

    function __construct()
    {

        $file = "http://www.tcmb.gov.tr/kurlar/today.xml";
        $this->defaultFilename = "TCMB_Kurlar.json"; // JSON çıktısının adı
        if (@get_headers($file)[0] == 'HTTP/1.1 404 Not Found') {
            $this->xmlStatus = false;
            die(date("Y-m-d") . " : TCMB'den kurlar çekilemiyor!");
        }
        $this->xmlStatus = true;
        $this->xml = simplexml_load_file($file);
        if (!$this->xml) {
            $this->xmlStatus = false;
            die(date("Y-m-d") . " : Kur dosyası XML'e parse edilemiyor!");
        }
        $this->attributes = $this->xml->attributes();
        $this->currencies = $this->xml->Currency;
        if (date("N") < 6 && $this->attributes["Date"] != date('m-d-Y')) // hafta içiyse ve kurlar güncellenmemişse
            die(date("Y-m-d") . " : Kurlar bugüne ait değil, dolayısıyla değişmemiş!\n");

        if (count($this->getAlanlar()) == 0)
            $this->setAlanlar(array(
                "Unit",
                "Isim",
                "CurrencyName",
                "ForexBuying",
                "ForexSelling",
                "BanknoteBuying",
                "BanknoteSelling",
                "CrossRateUSD",
                "CrossRateOther"
            ));

        if (count($this->getDovizKodlari()) == 0) {
            $this->setDovizKodlari(array("USD", "AUD", "DKK", "EUR", "GBP", "CHF", "SEK", "CAD", "KWD", "NOK", "SAR", "JPY", "BGN", "RON", "RUB", "IRR", "CNY", "PKR"));
        }
    }

    public function setAlanlar($alanlar)
    {
        $this->alanlar = $alanlar;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function setCurrencies()
    {
        for ($i = 0; $i < count($this->currencies); $i++) {
            $currentCurrency = $this->currencies[$i];
            $alanlar = $this->getAlanlar();

            switch ($i) {
                case 0:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->USD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 1:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->AUD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 2:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->DKK[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 3:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->EUR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 4:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->GBP[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 5:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->CHF[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 6:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->SEK[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 7:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->CAD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 8:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->KWD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 9:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->NOK[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 10:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->SAR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 11:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->JPY[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 12:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->BGN[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 13:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->RON[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 14:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->RUB[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 15:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->IRR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 16:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->CNY[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 17:
                    for ($j = 0; $j < count($this->alanlar); $j++) {
                        $this->PKR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
            }
        }

        $this->dovizler = array(
            "USD" => $this->USD,
            "AUD" => $this->AUD,
            "DKK" => $this->DKK,
            "EUR" => $this->EUR,
            "GBP" => $this->GBP,
            "CHF" => $this->CHF,
            "SEK" => $this->SEK,
            "CAD" => $this->CAD,
            "KWD" => $this->KWD,
            "NOK" => $this->NOK,
            "SAR" => $this->SAR,
            "JPY" => $this->JPY,
            "BGN" => $this->BGN,
            "RON" => $this->RON,
            "RUB" => $this->RUB,
            "IRR" => $this->IRR,
            "CNY" => $this->CNY,
            "PKR" => $this->PKR
        );
    }

    public function getAlanlar()
    {
        return $this->alanlar;
    }


    public function getDovizKodlari()
    {
        return $this->dovizKodlari;
    }

    public function setDovizKodlari($dovizKodlari)
    {
        $this->dovizKodlari = $dovizKodlari;
    }


    public function getUSD()
    {
        return $this->USD;
    }


    public function getAUD()
    {
        return $this->AUD;
    }


    public function getDKK()
    {
        return $this->DKK;
    }


    public function getEUR()
    {
        return $this->EUR;
    }


    public function getGBP()
    {
        return $this->GBP;
    }


    public function getCHF()
    {
        return $this->CHF;
    }


    public function getSEK()
    {
        return $this->SEK;
    }


    public function getCAD()
    {
        return $this->CAD;
    }


    public function getKWD()
    {
        return $this->KWD;
    }


    public function getNOK()
    {
        return $this->NOK;
    }


    public function getSAR()
    {
        return $this->SAR;
    }


    public function getJPY()
    {
        return $this->JPY;
    }


    public function getBGN()
    {
        return $this->BGN;
    }


    public function getRON()
    {
        return $this->RON;
    }


    public function getRUB()
    {
        return $this->RUB;
    }


    public function getIRR()
    {
        return $this->IRR;
    }


    public function getCNY()
    {
        return $this->CNY;
    }


    public function getPKR()
    {
        return $this->PKR;
    }

    public function getJSON()
    {
        $data = array();
        for ($i = 0; $i < count($this->dovizKodlari); $i++) {
            $data[$this->getDovizKodlari()[$i]] = $this->dovizler[$this->getDovizKodlari()[$i]];
        }
        return json_encode($data);
    }

    public function createJSONFile()
    {
        if (strlen($this->filename) == 0)
            $this->setFilename($this->defaultFilename);
        if (!$this->xmlStatus)
            return false;
        if (file_put_contents($this->filename, $this->getJSON()) != false)
            return true;
        else
            return date("Y-m-d H:i:s") . " : JSON dosyası oluşturulamıyor!";
    }

    private function str2float($str)
    {
        $ayracPos = strpos($str, '.');
        if ($ayracPos == false) {
            $ayracPos = strpos($str, ',');
            if ($ayracPos == false)
                return $str;
            else
                $floatValue = number_format($str * 1) + (substr($str, $ayracPos + 1) / pow(10, 4 - $ayracPos));
            return $floatValue;
        } else {
            return $str * 1;
        }
    }
}

$doviz = new TCMB_Kurlar();
$doviz->setAlanlar(array(
    "CurrencyName",
    "ForexBuying",
    "ForexSelling",
    "BanknoteBuying",
    "BanknoteSelling"
));
$doviz->setDovizKodlari(array(
    "USD",
    "EUR"
));
$doviz->setCurrencies();
$doviz->setFilename("tcmb_" . date("Ymd_His") . ".json");
echo $doviz->getJSON();
$doviz->createJSONFile();