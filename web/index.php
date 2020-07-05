<?php
ini_set('zlib.output_compression', 1);
ini_set('zlib.output_compression_level', 5);
require('../vendor/autoload.php');
use PHPHtmlParser\Dom;


if (!strpos($_SERVER['REQUEST_URI'], 'api/')) {
  include("index.html");
} else {


  $app = new Silex\Application();
  $app['debug'] = true;

  $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
      'driver'   => 'pdo_sqlite',
      'path'     => __DIR__.'/app.db',
    ),
  ));


//$app['db']->
//$app['dbs']['sqlite']
  $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array (
      'sqlite' => array(
        'driver'    => 'pdo_sqlite',
        'path'     => __DIR__.'/../src/manage/db/Sentences.db'
      ),
      'mysql_write' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'mysql_write.someplace.tld',
        'dbname'    => 'my_database',
        'user'      => 'my_username',
        'password'  => 'my_password',
        'charset'   => 'utf8mb4',
      ),
    ),
  ));
/*
$connectionParams = array(
  'dbname' => 'mydb',
  'user' => 'user',
  'password' => 'secret',
  'host' => 'localhost',
  'driver' => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
*/


//$query_text = htmlentities(trim($query_text), ENT_QUOTES);
//$query_text = str_replace("'", "''", trim($query_text));

// Register the monolog logging service
/*$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));*/

// Register view rendering
/*$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
  ));*/






  function getSearch($query_text, $limit, $min_size){
    ORM::configure('sqlite:../manage/db/Sentences.db');


    $query_text = strtolower($query_text);
    $dest = ORM::for_table('sentences')
    ->select_many('text')
    ->raw_query("select distinct text, length(text) count from sentences where text like '%$query_text%' and length(text) > $min_size and length(text) < 160 ORDER BY count limit 100")
//->where_like('text', '%'.$query_text.'%')
  //->where_raw("length(text) < 200 and text like '%$query_text%' ORDER BY tag DESC LIMIT 50")
    ->limit(100)
    ->find_array();

    ORM::resetDb();

    return array_map("cleanRow", $dest);
  }


  function getPostArticles($query_text, $limit, $min_size){
    ORM::configure('sqlite:../manage/db/Articles.db');
    $dest = ORM::for_table('posts')->where_like("title", '%'.$query_text.'%')->limit(100)->find_array();
    ORM::resetDb();
    return $dest;
  }

  function getVideoArticles($query_text, $limit, $min_size){
    ORM::configure('sqlite:../manage/db/Articles.db');
    $dest = ORM::for_table('youtube')->where_like("title", '%'.$query_text.'%')->limit(100)->find_array();
    ORM::resetDb();
    return $dest;
  }

  function getWords($query_text, $limit, $min_size){
    $dest = setDb("Sentences.db", 'important_words')->where_like("text", '%'.$query_text.'%')->limit(100)->find_array();

    return $dest;
  }

  function getFavorites($query_text, $limit, $min_size){

    $dest = setDb("Sentences.db", 'important_words')->limit(1000)->find_array();

    return $dest;
  }
  
  function textClean($query_text){

    
    $query_text = str_replace("'", "''", trim($query_text));
    return $query_text;
  }







  $app->get('/api/getSentences', function() use($app) {
    $query_text = $_GET['text'];
    $sentences = setDb("Sentences.db", 'sentences');
    //$sentences = $sentences->where_like('text', '%'.$query_text.'%')->limit(100)->find_array();
    $sentences = $sentences
    //->raw_query("select distinct text, length(text) count from sentences where text like '%$query_text%' ORDER BY count limit 100")
    ->where_raw("text like '%$query_text%' ORDER BY length(text)")
    ->limit(100)->find_array();
    return $app->json(['getSearch' => $sentences], 200);
  });



  $app->get('/api/addFavorite', function() use($app) {
    $query_text = textClean($_GET['text']);
      $getText = setDb("Sentences.db", 'important_words')->where('text', $query_text)->limit(1)->find_array();
  if (!count($getText)) {
    $word = setDb("Sentences.db", 'important_words')->create();
    $word->text = $query_text;
    $word->save();

  }
    return $app->json([$word->id()], 200);
  });

  $app->get('/api/getLinks/{query_text}', function($query_text) use($app) {
    $dest = setDb("Articles.db", 'full_articles');
    $dest = $dest
    ->where_not_like('url', '%codepen%')
    ->where_like('title', '%'.$query_text.'%')
    ->limit(100)->find_array();
    return $app->json($dest, 200);
  })->value('query_text', 'css');

  $app->get('/api/getFavorites', function() use($app) {
    $dest = getFavorites(0,0,0);
    return $app->json($dest, 200);
  });



  $app->get('/api/getLink', function() use($app) {

    $fullText = "";
    $url = htmlentities(trim($_GET['url']), ENT_QUOTES);
    if (isset($_GET['url'])) {

      $html = file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));



      $dom = new Dom;
      $dom->loadStr($html, [
        'removeScripts' => true,
        'removeStyles' => true,
        'htmlSpecialCharsDecode' => false,
        'whitespaceTextNode' => false,
      ]);
      $findArr = 'p, h1, h2, h3, h4, h6, a, table';
      $totalArr = [];
      foreach ($dom->find($findArr) as $key => $content)
      {
        $totalArr = cleanContent($content, $totalArr);
      }

    }



    $fullText = implode('. ', $totalArr);
    $fullText = str_replace('. . ', '. ', $fullText);
    $fullText = str_replace('.. ', '. ', $fullText);
    $fullText = str_replace('. .', '. ', $fullText);
    $fullText = str_replace('. . .', '', $fullText);
    $fullText = str_replace("\r", "", $fullText);
    $fullText = str_replace('"', "'", $fullText);
    $fullText = str_replace("\n", " ", $fullText);
    $fullText = trim($fullText);


    $strArr  = preg_split('/(?<=[.?!])\s+(?=[A-Z])/i', $fullText, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    $bodyString = implode(" ", $strArr);


    $sentences  = $bodyString;
    $strArr = array_map(function($tag) {
      return array(
        'text' => $tag
      );
    }, $strArr);
    return $app->json($strArr, 200);
  });

  $app->get('/', function() use($app) {
    return $app->json([], 200);
  });
  $app->run();
}
