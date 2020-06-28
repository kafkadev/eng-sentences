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



function jsonResponse($data)
{
  header("Access-Control-Allow-Origin: http://127.0.0.1:8887");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');
  return json_encode($data);
}
