<?php
//ORM::configure('sqlite:../sentences/manage/db/BasicDictionary.db');
/*!
 * Nanite
 * Copyright (C) 2012-2016 Jack P.
 * https://github.com/nirix
 *
 * Nanite is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; version 3 only.
 *
 * Nanite is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Nanite. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Shortcut to the Nanite::get() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function getQuery($param = 0)
{
  if ($param) {
    $params = isset($_GET) && isset($_GET[$param]) ? $_GET[$param] : 0;
  } else {
    $params = isset($_GET) ? $_GET : [];

  }
  return $params;

}




function cleanContent($data, $totalArr) {


  $str = html_entity_decode($data->innerHtml, ENT_QUOTES);
  $str = htmlspecialchars_decode($str, ENT_QUOTES);
  $find=[
              //"/<b>(.*?)<\/b>/",
    '(<\s*code[^>]*>([\s\S]*)<\s*/\s*code>)',
    '(<\s*pre[^>]*>([\s\S]*)<\s*/\s*pre>)',
    '~<pre(.*?)</pre>~Usi',
    '(<\s*[^>]*>)',
    "#http?\://([^\s*]+)#si",
    "#www?\://([^\s*]+)#si",
              //"#com?([^\s*]+)#si",
    "#\s{2,}#si",
  ];

  $str = preg_replace($find," ",$str);
  $str = strip_tags($str, '');

  if (strlen(trim($str)) > 20 && !in_array(trim($str), $totalArr)) {
    $totalArr[] = trim($str);
  }
  return $totalArr;
}


function cleanRow($row)
{

  $str = html_entity_decode($row['text'], ENT_QUOTES);
  $str = htmlspecialchars_decode($str, ENT_QUOTES);
  $find=[
    '/<b>(.*?)<\/b>/',
    '(<\s*code[^>]*>([\s\S]*)<\s*/\s*code>)',
    '~<pre(.*?)</pre>~Usi',
    '(<\s*[^>]*>)',
    "#http?\://([^\s*]+)#si",
    "#www?\://([^\s*]+)#si",
              //"#.com?([^\s*]+)#si",
    "#\s{2,}#si",
  ];

  $str = preg_replace($find," ",$str);
  $row['text'] = trim(strip_tags($str, ''));
  return $row;
}


  function getDictFamily($query_text, $limit, $min_size){
    ORM::configure('sqlite:../manage/db/BasicDictionary.db');
    $query_text = str_replace('.', '', $query_text);
    $dest = ORM::for_table('important_words')->where_like("text", '%'.$query_text.'%')->limit(100)->find_array();
    ORM::resetDb();

    return $dest;
  }
  function getDict($query_text, $limit, $min_size){
 // ORM::configure('sqlite:../manage/db/BasicDictionary.db');
    $query_text = str_replace('.', '', $query_text);
    $dest = setDb("BasicDictionary.db", 'words');
    $dest->where_like('word', strtolower(trim($query_text)).'%')
    ->order_by_asc('word')
    ->limit(50)
    ->find_array();
    ORM::resetDb();

    return $dest;
  }


  function getSubtitles($query_text, $limit, $min_size){
    ORM::configure('sqlite:../manage/db/Subtitles.db');


    $query_text = strtolower($query_text);
    $dest = ORM::for_table('vtt')
    ->select_many('fullname')
    ->raw_query("select distinct text as shortname, length(text) count, text || ' , ' || name as text  from vtt where text like '%$query_text%' and length(text) > 10 and length(text) < 160 ORDER BY count limit 100")
//->where_like('text', '%'.$query_text.'%')
  //->where_raw("length(text) < 200 and text like '%$query_text%' ORDER BY tag DESC LIMIT 50")
    ->limit(100)
    ->find_array();

    ORM::resetDb();

    return array_map("cleanRow", $dest);
  }




function setDb($dbName = 'BasicDictionary.db', $table = 0)
{
  ORM::resetDb();
  ORM::configure('sqlite:../src/manage/db/' . $dbName);
  return ORM::for_table($table);
}



function getGoogleTranslate($text = "nature")
{
$source = 'auto';
$target = 'en';
//$text = "nature";
$translation = GoogleTranslate::translate($source, $target, $text);

return $translation;
}

function jsonResponse($data)
{
  header("Access-Control-Allow-Origin: http://127.0.0.1:8887");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');
  return json_encode($data);
}



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
        $path = 'https://translate.google.com/translate_a/single';
$url = $path ."?client=at&inputm=2&dj=1&dt=at&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&hl=en-US&ie=UTF-8&oe=UTF-8&otf=2&ssel=5&tsel=5&kc=9&iid=1dd3b944-fa62-4b55-b330-74909a99969e";
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
