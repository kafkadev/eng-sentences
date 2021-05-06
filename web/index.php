<?php
ini_set('zlib.output_compression', 1);
ini_set('zlib.output_compression_level', 5);
require '../vendor/autoload.php';
use PHPHtmlParser\Dom;



$app          = new Silex\Application();
$app['debug'] = true;
$app['cache.path'] = __DIR__.'/cache';
$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/cache/',
    'http_cache.esi'       => null,
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
    'twig.cache' => false,
    'cache' => false,
    'twig.auto_reload' => true,
    'auto_reload' => true
));



$app->after(function ($request, $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});



function generateCsv($data = [], $fileName = 'epey', $delimiter = ',', $enclosure = '"') {


  $handle = fopen($fileName . '.csv', 'a');
  foreach ($data as $line) {
   fputcsv($handle, $line, $delimiter, $enclosure);
}
fclose($handle);
}


function addFavorite($text) {
    if ($text) {
        $word        = setDb("Sentences.db", 'favorite_sentences')
        ->where('text', $text)
        ->limit(1)
        ->find_one();

if(!$word) {
        $word       = setDb("Sentences.db", 'favorite_sentences')->create();
        $word->text = $text;
        $word->save();
    }
}

}





function getSearch($query_text, $limit, $min_size)
{
    ORM::configure('sqlite:../manage/db/Sentences.db');

    $query_text = strtolower($query_text);
    $dest       = ORM::for_table('sentences')
    ->select_many('text')
    ->raw_query("select distinct text, length(text) count from sentences where text like '%$query_text%' and length(text) > $min_size and length(text) < 160 ORDER BY count limit 100")
//->where_like('text', '%'.$query_text.'%')
        //->where_raw("length(text) < 200 and text like '%$query_text%' ORDER BY tag DESC LIMIT 50")
    ->limit(100)
    ->find_array();

    ORM::resetDb();

    return array_map("cleanRow", $dest);
}

function getPostArticles($query_text, $limit, $min_size)
{
    ORM::configure('sqlite:../manage/db/Articles.db');
    $dest = ORM::for_table('posts')->where_like("title", '%' . $query_text . '%')->limit(100)->find_array();
    ORM::resetDb();
    return $dest;
}

function getVideoArticles($query_text, $limit, $min_size)
{
    ORM::configure('sqlite:../manage/db/Articles.db');
    $dest = ORM::for_table('youtube')->where_like("title", '%' . $query_text . '%')->limit(100)->find_array();
    ORM::resetDb();
    return $dest;
}

function getWords($query_text, $limit, $min_size)
{
    $dest = setDb("Sentences.db", 'favorite_sentences')->where_like("text", '%' . $query_text . '%')->limit(100)->find_array();

    return $dest;
}

function getFavoriteSentences($query_text, $limit, $min_size)
{

    $dest = setDb("Sentences.db", 'favorite_sentences')
    ->where_like('text', '% %')
    ->limit(5000)->find_array();

    return $dest;
}
function getFavoriteWords($query_text, $limit, $min_size)
{

    $dest = setDb("Sentences.db", 'favorite_sentences')
    ->select_many('text','id')
    ->where_not_like('text', '% %')
    ->limit(5000)->find_array();

    return $dest;
}

function textClean($query_text)
{

    $query_text = str_replace("'", "''", trim($query_text));
    return $query_text;
}

$app->get('/api/getSentences', function () use ($app) {
    $query_text = $_GET['text'];

    $has_query_text = textClean($query_text);
    addFavorite($has_query_text);

    $sentences = setDb("Sentences.db", 'sentences');
        //$sentences = $sentences->where_like('text', '%'.$query_text.'%')->limit(100)->find_array();
    $sentences = $sentences
        //->raw_query("select distinct text, length(text) count from sentences where text like '%$query_text%' ORDER BY count limit 100")
    ->where_raw("text like '% $query_text' OR text like '$query_text %' OR text like '% $query_text %' ORDER BY length(text)")
    ->limit(250)->find_array();
    $getDictionary = setDb("BasicDictionary.db", 'words')
    ->where("word", $query_text)->limit(250)->find_array();
    $getSynonyms = setDb("BasicDictionary.db", 'synonyms')
    ->where("word", $query_text)->limit(250)->find_array();
    $getDictionarySentences = setDb("BasicDictionary.db", 'important_words')
    ->where_raw("text = '$query_text' OR text like '% $query_text' OR text like '$query_text %' OR text like '% $query_text %' ORDER BY type, text")
        //->where_like('text', '%' . $query_text . '%')
    ->limit(250)->find_array();

    return $app->json([
        'getSearch' => $sentences,
        'getDict' => $getDictionary,
        'getSynonyms' => $getSynonyms,
        'getWords'  => $getDictionarySentences,
    ], 200);
});

$app->get('/api/addFavorite', function () use ($app) {
    $query_text = textClean($_GET['text']);
    addFavorite($query_text);
    return $app->json([], 200);
});

$app->get('/api/getLinks/{query_text}', function ($query_text) use ($app) {
    $dest = setDb("Articles.db", 'full_articles');
    $dest = $dest
    ->where_not_like('url', '%codepen%')
    ->where_like('title', '%' . $query_text . '%')
    ->limit(100)->find_array();
    return $app->json($dest, 200);
})->value('query_text', 'css');

$app->get('/api/getFavorites', function () use ($app) {
    $dest = getFavorites(0, 0, 0);
    return $app->json($dest, 200);
});


$app->get('/api/getLinkHistory', function () use ($app) {
    $dest = setDb("Sentences.db", 'exported_links')
    ->limit(2000)
    ->order_by_desc('id')->find_array();
    return $app->json($dest, 200);
});


$app->get('/api/setcsv', function () use ($app) {
    //generateCsv($data = [], $fileName = 'epey', $delimiter = ',', $enclosure = '"')
    $words = file_get_contents('data/eng-roots.json', 1);
    $words = json_decode($words, 1);
    $arrRoot = [];
    foreach ($words as $key => $item) {
     $ret = [
        "type" => "root",
        "text" => $key . ' | ' . implode(' | ', $item['examples']),
        "defn" => implode(' | ', $item['meanings']),
    ];
    array_push($arrRoot, $ret);
}

generateCsv($arrRoot, 'root');


return $app->json($arrRoot, 200);
});

$app->get('/api/getTopWords', function () use ($app) {
    $dest    = setDb("BasicDictionary.db", 'top_words')
    ->select_many('text')->limit(5000)->find_array();
    return $app->json($dest, 200);
});
$app->get('/api/getFavoriteSentences', function () use ($app) {
    $dest = getFavoriteSentences(0, 0, 0);
    return $app->json($dest, 200);
});
$app->get('/api/getFavoriteWords', function () use ($app) {
    $dest = getFavoriteWords(0, 0, 0);
    return $app->json($dest, 200);
});

$app->get('/api/getDictionarySentences/{query_text}', function ($query_text) use ($app) {

    $dest = setDb("BasicDictionary.db", 'important_words');
    $dest = $dest
    ->raw_query("select distinct text from important_words where type = '$query_text' limit 5000")->find_array();
    return $app->json($dest, 200);
});

$app->get('/api/getLink', function () use ($app) {


    $strArr =  [];
    if (isset($_GET['url'])) {

        $fullText = "";
        $url      = htmlentities(trim($_GET['url']), ENT_QUOTES);


        $link    = setDb("Sentences.db", 'exported_links')->where('link', $url)->limit(1)->find_array();
        if (!count($link)) {
            $word       = setDb("Sentences.db", 'exported_links')->create();
            $word->link = $url;
            $word->save();
        }



        $html = file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));

        $dom = new Dom;
        $dom->loadStr($html, [
            'removeScripts'          => true,
            'removeStyles'           => true,
            'htmlSpecialCharsDecode' => false,
            'whitespaceTextNode'     => false,
        ]);
        $findArr  = 'title, div, p, h1, h2, h3, h4, h6, a, table, li';
        $totalArr = [];
        foreach ($dom->find($findArr) as $key => $content) {
            $totalArr = cleanContent($content, $totalArr);
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

        $strArr     = preg_split('/(?<=[.?!])\s+(?=[A-Z])/i', $fullText, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $bodyString = implode(" ", $strArr);

        $sentences = $bodyString;




        $strArr    = array_map(function ($tag) {
            if (strlen($tag) < 110) {
             setDb("Sentences.db", 'sentences')->raw_execute("INSERT INTO sentences (text) VALUES(:text)",['text' => $tag]);
            }

            return array(
                'text' => $tag,
            );
        }, $strArr);
    }
             setDb("Sentences.db", 'sentences')->raw_execute("DELETE FROM sentences WHERE ID NOT IN (SELECT MIN(ID) FROM sentences GROUP BY text)");


    return $app->json($strArr, 200);
});


$app->get('/api/getLinkFrame', function () use ($app) {

    $fullText = "";
    $url      = htmlentities(trim($_GET['url']), ENT_QUOTES);
    $urlParse      = implode('/',array_slice(explode('/', $url), 0,3));
    if (isset($_GET['url'])) {
        $html = file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
        $dom = new Dom;
        $dom->loadStr($html, [
            'removeScripts'          => true,
            'removeStyles'           => true,
            'htmlSpecialCharsDecode' => false,
            'whitespaceTextNode'     => false,
        ]);
        $html = $dom->innerHtml;
        $html = str_replace("head>", "head><base href='".$urlParse."/'>", $html);
        return strip_tags($html, '<html><head><body><base><meta><p><br><span><h1><h2><h3><h4><div><ul><li><code><style><link><title><link/><b><button><a>');
    }
});


$app->get('/api/testhtml', function () use ($app) {
//api/testhtml?text=what
    $query_text = $_GET['text'];

    $has_query_text = textClean($query_text);


    $sentences = setDb("Sentences.db", 'sentences');
        //$sentences = $sentences->where_like('text', '%'.$query_text.'%')->limit(100)->find_array();
    $sentences = $sentences
        //->raw_query("select distinct text, length(text) count from sentences where text like '%$query_text%' ORDER BY count limit 100")
    ->where_raw("text like '% $query_text' OR text like '$query_text %' OR text like '% $query_text %' ORDER BY length(text)")
    ->limit(50)->find_array();
    $getDictionarySentences = setDb("BasicDictionary.db", 'important_words')
    ->where_raw("text = '$query_text' OR text like '% $query_text' OR text like '$query_text %' OR text like '% $query_text %' ORDER BY type, text")
        //->where_like('text', '%' . $query_text . '%')
    ->limit(20)->find_array();

    return $app['twig']->render('tablepop.html', [
        'mainText' => $query_text,
        'searchs' => $sentences,
        'getWords'  => $getDictionarySentences,
    ]);


   /* return $app->json([
        'getSearch' => $sentences,
        'getWords'  => $getDictionarySentences,
    ], 200);*/
});








$app->get('/testhtml2', function () use ($app) {
    return $app['twig']->render('tablepop.html', ['name' => 'Fabien']);
});

$app->get('/api/getGoogleTranslate', function () use ($app) {
        $query_text = $_GET['text'];
   $resp =  getGoogleTranslate($query_text);
    return $app->json($resp, 200);
});


$app->get('/', function () use ($app) {
    return include "index.html";
});
$app->run();
