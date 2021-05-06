<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: http://127.0.0.1:8887");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
//require_once('GoogleTranslate.class.php');
$source = 'en';
$target = 'tr';
$text = "nature";
$translation = GoogleTranslate::translate($source, $target, $text);
/*echo '<pre>';
print_r($translation);
echo '</pre>';*/
echo json_encode($translation);


//********************************************************************


/**
 * GoogleTranslate.class.php
 *
 * Class to talk with Google Translator.
 *
 * @category   Translation
 * @author     Adrián Barrio Andrés
 * @copyright  2016 Adrián Barrio Andrés
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    1.0
 * @link       https://statickidz.com/
 */

class GoogleTranslate
{

    /**
     * @param string $source
     * @param string $target
     * @param string $text
     * @return string
     */
    public static function translate($source, $target, $text) {

        // Request translation
        $response = self::requestTranslation($source, $target, $text);

        // Get translation text
        //$response = self::getStringBetween("onmouseout=\"this.style.backgroundColor='#fff'\">", "</span></div>", strval($response));

        // Clean translation
        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }

    /**
     * @param string $source
     * @param string $target
     * @param string $text
     * @return array
     */
    protected static function requestTranslation($source, $target, $text) {

        // Google translate URL
        $url = "https://translate.google.com/translate_a/single?
        client=at
        &dt=t
        &dt=ld
        &dt=qca
        &dt=rm
        &dt=bd
        &dj=1
        &inputm=2
        &hl=tr-TR
        &ie=UTF-8
        &oe=UTF-8
        &otf=2
        &iid=1dd3b944-fa62-4b55-b330-74909a99969e";
      $url = "https://translate.google.com/translate_a/single?client=at&inputm=2&dj=1&dt=at&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&hl=tr-TR&ie=UTF-8&oe=UTF-8&otf=2&ssel=5&tsel=5&kc=9&iid=1dd3b944-fa62-4b55-b330-74909a99969e";
      $url = implode('', explode(' ', $url));
//`https://translate.google.com/translate_a/single?client=t&dt=at&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&ie=UTF-8&oe=UTF-8&otf=1&ssel=5&tsel=5&kc=9&tk=${token.value}&q=${encodeURIComponent(word)}`,
        $fields = array(
            'sl' => urlencode($source),
            'tl' => urlencode($target),
            'q' => urlencode($text)
        );

        // URL-ify the data for the POST
        $fields_string = "";
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }

        rtrim($fields_string, '&');

        // Open connection
        $ch = curl_init();
//print_r($url);
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }


    /**
     * @param string $json
     * @return string
     */
    protected static function getSentencesFromJSON($json) {
        $sentencesArray = json_decode($json, true);


        $sentences = "";

       /* foreach ($sentencesArray["sentences"] as $s) {
            $sentences .= $s["trans"];
        }*/

        return $sentencesArray;
    }

}

?>
