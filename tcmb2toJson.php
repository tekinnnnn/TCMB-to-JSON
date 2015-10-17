<?php

/**
 * Class TCMB_Kurlar
 */
class TCMB_Kurlar
{
    /**
     * @var
     */
    public $USD; // ABD DOLARI
    /**
     * @var
     */
    public $AUD; // AVUSTRALYA DOLARI
    /**
     * @var
     */
    public $DKK; // DANİMARKA KRONU
    /**
     * @var
     */
    public $EUR; // EURO
    /**
     * @var
     */
    public $GBP; // İNGİLİZ STERLİNİ
    /**
     * @var
     */
    public $CHF; // İSVİÇRE FRANGI
    /**
     * @var
     */
    public $SEK; // İSVEÇ KRONU
    /**
     * @var
     */
    public $CAD; // KANADA DOLARI
    /**
     * @var
     */
    public $KWD; // KUVEYT DİNARI
    /**
     * @var
     */
    public $NOK; // NORVEÇ KRONU
    /**
     * @var
     */
    public $SAR; // SUUDİ ARABİSTAN RİYALİ
    /**
     * @var
     */
    public $JPY; // JAPON YENİ
    /**
     * @var
     */
    public $BGN; // BULGAR LEVASI
    /**
     * @var
     */
    public $RON; // RUMEN LEYİ
    /**
     * @var
     */
    public $RUB; // RUS RUBLESİ
    /**
     * @var
     */
    public $IRR; // İRAN RİYALİ
    /**
     * @var
     */
    public $CNY; // ÇİN YUANI
    /**
     * @var
     */
    public $PKR; // PAKİSTAN RUPİSİ

    /**
     * @var SimpleXMLElement
     */
    private $xml; // xml

    /**
     * @var SimpleXMLElement
     */
    private $attributes;
    /**
     * @var
     */
    private $currencies;
    /**
     * @var bool
     */
    private $xmlStatus;

    /**
     * @param array $dovizKodu
     * @param array $alanlar
     */
    function __construct($dovizKodlari = array(), $alanlar = array())
    {

        $file = "http://www.tcmb.gov.tr/kurlar/today.xml";
        $this->filename = "TCMB_Kurlar.json"; // JSON çıktısının adı
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

        if (!isset($alanlar) || count($alanlar) == 0)
            $this->alanlar = array(
                "Unit",
                "Isim",
                "CurrencyName",
                "ForexBuying",
                "ForexSelling",
                "BanknoteBuying",
                "BanknoteSelling",
                "CrossRateUSD",
                "CrossRateOther"
            );
        else
            $this->alanlar = $alanlar;

        $this->degerleriAta($this->alanlar);

        if (count($dovizKodlari) > 0) {
            $this->dovizKodlari = $dovizKodlari;
        } else {
            $this->dovizKodlari = array("USD", "AUD", "DKK", "EUR", "GBP", "CHF", "SEK", "CAD", "KWD", "NOK", "SAR", "JPY", "BGN", "RON", "RUB", "IRR", "CNY", "PKR");
        }
    }

    /**
     * @param $alanlar
     */
    private function degerleriAta($alanlar)
    {
        for ($i = 0; $i < count($this->currencies); $i++) {
            $currentCurrency = $this->currencies[$i];

            switch ($i) {
                case 0:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->USD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 1:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->AUD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 2:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->DKK[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 3:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->EUR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 4:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->GBP[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 5:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->CHF[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 6:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->SEK[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 7:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->CAD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 8:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->KWD[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 9:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->NOK[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 10:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->SAR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 11:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->JPY[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 12:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->BGN[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 13:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->RON[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 14:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->RUB[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 15:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->IRR[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 16:
                    for ($j = 0; $j < count($alanlar); $j++) {
                        $this->CNY[$alanlar[$j]] = $this->str2float("{$currentCurrency->$alanlar[$j]}");
                    }
                    break;
                case 17:
                    for ($j = 0; $j < count($alanlar); $j++) {
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

    /**
     * @return mixed
     */
    public function getUSD()
    {
        return $this->USD;
    }

    /**
     * @return mixed
     */
    public function getAUD()
    {
        return $this->AUD;
    }

    /**
     * @return mixed
     */
    public function getDKK()
    {
        return $this->DKK;
    }

    /**
     * @return mixed
     */
    public function getEUR()
    {
        return $this->EUR;
    }

    /**
     * @return mixed
     */
    public function getGBP()
    {
        return $this->GBP;
    }

    /**
     * @return mixed
     */
    public function getCHF()
    {
        return $this->CHF;
    }

    /**
     * @return mixed
     */
    public function getSEK()
    {
        return $this->SEK;
    }

    /**
     * @return mixed
     */
    public function getCAD()
    {
        return $this->CAD;
    }

    /**
     * @return mixed
     */
    public function getKWD()
    {
        return $this->KWD;
    }

    /**
     * @return mixed
     */
    public function getNOK()
    {
        return $this->NOK;
    }

    /**
     * @return mixed
     */
    public function getSAR()
    {
        return $this->SAR;
    }

    /**
     * @return mixed
     */
    public function getJPY()
    {
        return $this->JPY;
    }

    /**
     * @return mixed
     */
    public function getBGN()
    {
        return $this->BGN;
    }

    /**
     * @return mixed
     */
    public function getRON()
    {
        return $this->RON;
    }

    /**
     * @return mixed
     */
    public function getRUB()
    {
        return $this->RUB;
    }

    /**
     * @return mixed
     */
    public function getIRR()
    {
        return $this->IRR;
    }

    /**
     * @return mixed
     */
    public function getCNY()
    {
        return $this->CNY;
    }

    /**
     * @return mixed
     */
    public function getPKR()
    {
        return $this->PKR;
    }

    /**
     * @param $str
     * @return string | int | float
     */
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

    /**
     * @param null $filename
     */
    public function JSONGuncelle()
    {
        if (!$this->xmlStatus)
            return false;
        $data = array();
        for ($i = 0; $i < count($this->dovizKodlari); $i++) {
            $data[$this->dovizKodlari[$i]] = $this->dovizler[$this->dovizKodlari[$i]];
        }
        if (file_put_contents($this->filename, json_encode($data)) != false)
            return true;
        else
            return date("Y-m-d H:i:s") . " : JSON dosyası oluşturulamıyor!";
    }

}

$doviz = new TCMB_Kurlar(array("EUR", "USD"), array("BanknoteBuying", "BanknoteSelling"));
$doviz->JSONGuncelle();