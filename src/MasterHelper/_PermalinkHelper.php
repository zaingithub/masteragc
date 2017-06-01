<?php

/* RENDER PERMALINK */

function render_permalink( $term , $extension = '.html' ) {
	return home_url().'/'.clean($term, '-').''.$extension.'';
}

function attachment_link($query, $subquery, $id = 0) {
	return home_url().'/'.clean($query, '-').'/'.$id.'/'.clean($subquery, '-').'';	
}

/* MAKE SINGLE PERMALINK */

function single_permalink($title, $id) {
	$url = clean($title, '-') .'_'.$id.'.html';
	return home_url() .'/'. $url;
}

/* STRIP ALL TAGS */

function strip_all_tags($string, $remove_breaks = false) {

	$string = strip_tags($string, '<b><img><p><noscript><li><br><ul><span><table><tr><th><td>');
    $string = preg_replace( '@<(script|style|noscript)[^>]*?>.*?</\\1>@si', '', $string );
	$string = preg_replace('/class=".*?"/', '', $string);
	$string = preg_replace('/style=".*?"/', '', $string);
  $string = preg_replace('/id=".*?"/', '', $string);
	$string = str_replace('data-original', 'src', $string);
	$string = preg_replace('#(" src.*?).*?(alt)#', '" $2', $string);
  $string = str_replace('">','',$string);
	$string = str_replace('<img','<img rel="nofollow"', $string);
    if ( $remove_breaks )
        $string = preg_replace('/[\r\n\t ]+/', ' ', $string);

    return trim( $string );
}

/* LIMIT WORDS */

function limit_the_words($text, $mark) {
	if (is_numeric($mark)) {
		$text = explode(" ",$text);
		$text = implode(" ",array_splice($text,0,$mark));
	} else {
		$text = explode($mark, $text)[0];
	}
	return $text;
}

/* HOME URL */

function home_url() {
	$home = 'http://'.$_SERVER['SERVER_NAME'];
	return $home;
}

/* GET CURRENT URL */

function get_permalink() {
	$current = "http://" . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "";
return $current;
}

/* REMOVE ALL NUMBER FROM STRING */

function clean_number($text) {
	$tt	= trim(preg_replace('/[0-9]+/', '', $text));
	return clean($tt);
}

/* CONVERT TO CLEAN STRING */

function clean($text, $delimiter = ' ') {
    $utf8 = array(
        '/[áàâãªä]/x'   =>   'a',
        '/[ÁÀÂÃÄ]/x'    =>   'A',
        '/[ÍÌÎÏ]/x'     =>   'I',
        '/[íìîï]/x'     =>   'i',
        '/[éèêë]/x'     =>   'e',
        '/[ÉÈÊË]/x'     =>   'E',
        '/[óòôõºö]/x'   =>   'o',
        '/[ÓÒÔÕÖ]/x'    =>   'O',
        '/[úùûü]/x'     =>   'u',
        '/[ÚÙÛÜ]/x'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-',
        '/[’‘‹›‚]/x'    =>   ' ',
        '/[“”«»„]/x'    =>   ' ',
        '/ /'           =>   ' ',
    );
    $aneh = array(
      "\\u003cb\\u003e",
      "\\u003c\\/b\\u003e",
      "\\u003c\\/b\\u003e",
      "\\u003cb\\u003e",
      "\\u003c\\/b\\u003e",
      "\\u003cb\\u003e",
      "\\u003cb\\u003e",
      "\\u003c\\/b\\u003e",
      "\\u0026amp;",
      "\\u003cb\\u003e",
      "\\u0026",
      "\\u0026#39;",
      "#39;",
      "\\u003c\\/b\\u003e",
      "\\u2013",
      "2013"
    );
	$remove	= array(' &amp; ', ' & ', '&amp;','&');
	$tt = str_replace($remove, '', $text);
//	$tt = clean_common_words($tt);
	$tt = remove_extension(strtolower($text));
	$tt = preg_replace(array_keys($utf8), array_values($utf8), $tt);
	$tt = preg_replace('/(\+\d{4,}|\d{4,})/i', ' ', $tt);
	$tt = preg_replace("![^a-z0-9]+!i", " ", $tt);
	$tt = preg_replace('/(\s+|\s{1,})/i', $delimiter, $tt);
	$tt = preg_replace('/[0-9]+/', '', $tt);
	$tt = implode($delimiter,array_unique(explode($delimiter, $tt)));
	$tt = trim(preg_replace("/(^|\s+)(\S(\s+|$))+/", $delimiter, $tt));
//	$tt = clean_common_words($tt);
	$tt = preg_replace('!\s+!', $delimiter, $tt);
	$tt = preg_replace('/\b\w\b\s?/', '', $tt);
	$tt = str_replace($aneh, '', $tt);
	$tt = preg_replace(array('/\b\w{1,2}\b/','/\s+/'),array('',' '),$tt);
	return trim($tt, $delimiter);
}

/* REMOVE ALL TLD EXTENSION */

function remove_extension($string){
	$replace = preg_replace('/(www\.|\.com|\.org|\.net|\.int|\.edu|\.gov|\.mil|\.ac|\.ad|\.ae|\.af|\.ag|\.ai|\.al|\.am|\.an|\.ao|\.aq|\.ar|\.as|\.at|\.au|\.aw|\.ax|\.az|\.ba|\.bb|\.bd|\.be|\.bf|\.bg|\.bh|\.bi|\.bj|\.bm|\.bn|\.bo|\.bq|\.br|\.bs|\.bt|\.bv|\.bw|\.by|\.bz|\.bzh|\.ca|\.cc|\.cd|\.cf|\.cg|\.ch|\.ci|\.ck|\.cl|\.cm|\.cn|\.co|\.cr|\.cs|\.cu|\.cv|\.cw|\.cx|\.cy|\.cz|\.dd|\.de|\.dj|\.dk|\.dm|\.do|\.dz|\.ec|\.ee|\.eg|\.eh|\.er|\.es|\.et|\.eu|\.fi|\.fj|\.fk|\.fm|\.fo|\.fr|\.ga|\.gb|\.gd|\.ge|\.gf|\.gg|\.gh|\.gi|\.gl|\.gm|\.gn|\.gp|\.gq|\.gr|\.gs|\.gt|\.gu|\.gw|\.gy|\.hk|\.hm|\.hn|\.hr|\.ht|\.hu|\.id|\.ie|\.il|\.im|\.in|\.io|\.iq|\.ir|\.is|\.it|\.je|\.jm|\.jo|\.jp|\.ke|\.kg|\.kh|\.ki|\.km|\.kn|\.kp|\.kr|\.krd|\.kw|\.ky|\.kz|\.la|\.lb|\.lc|\.li|\.lk|\.lr|\.ls|\.lt|\.lu|\.lv|\.ly|\.ma|\.mc|\.md|\.me|\.mg|\.mh|\.mk|\.ml|\.mm|\.mn|\.mo|\.mp|\.mq|\.mr|\.ms|\.mt|\.mu|\.mv|\.mw|\.mx|\.my|\.mz|\.na|\.nc|\.ne|\.nf|\.ng|\.ni|\.nl|\.no|\.np|\.nr|\.nu|\.nz|\.om|\.pa|\.pe|\.pf|\.pg|\.ph|\.pk|\.pl|\.pm|\.pn|\.pr|\.ps|\.pt|\.pw|\.py|\.qa|\.re|\.ro|\.rs|\.ru|\.rw|\.sa|\.sb|\.sc|\.sd|\.se|\.sg|\.sh|\.si|\.sj|\.sk|\.sl|\.sm|\.sn|\.so|\.sr|\.ss|\.st|\.su|\.sv|\.sx|\.sy|\.sz|\.tc|\.td|\.tf|\.tg|\.th|\.tj|\.tk|\.tl|\.tm|\.tn|\.to|\.tp|\.tr|\.tt|\.tv|\.tw|\.tz|\.ua|\.ug|\.uk|\.us|\.uy|\.uz|\.va|\.vc|\.ve|\.vg|\.vi|\.vn|\.vu|\.wf|\.ws|\.ye|\.yt|\.yu|\.za|\.zm|\.zr|\.zw|\.academy|\.accountants|\.active|\.actor|\.adult|\.aero|\.agency|\.airforce|\.app|\.archi|\.army|\.associates|\.attorney|\.auction|\.audio|\.autos|\.band|\.bar|\.bargains|\.beer|\.best|\.bid|\.bike|\.bio|\.biz|\.black|\.blackfriday|\.blog|\.blue|\.boo|\.boutique|\.build|\.builders|\.business|\.buzz|\.cab|\.camera|\.camp|\.cancerresearch|\.capital|\.cards|\.care|\.career|\.careers|\.cash|\.catering|\.center|\.ceo|\.channel|\.cheap|\.christmas|\.church|\.city|\.claims|\.cleaning|\.click|\.clinic|\.clothing|\.club|\.coach|\.codes|\.coffee|\.college|\.community|\.company|\.computer|\.condos|\.construction|\.consulting|\.contractors|\.cooking|\.cool|\.country|\.credit|\.creditcard|\.cricket|\.cruises|\.dad|\.dance|\.dating|\.day|\.deals|\.degree|\.delivery|\.democrat|\.dental|\.dentist|\.diamonds|\.diet|\.digital|\.direct|\.directory|\.discount|\.domains|\.eat|\.education|\.email|\.energy|\.engineer|\.engineering|\.equipment|\.esq|\.estate|\.events|\.exchange|\.expert|\.exposed|\.fail|\.farm|\.fashion|\.feedback|\.finance|\.financial|\.fish|\.fishing|\.fit|\.fitness|\.flights|\.florist|\.flowers|\.fly|\.foo|\.forsale|\.foundation|\.fund|\.furniture|\.gallery|\.garden|\.gift|\.gifts|\.gives|\.glass|\.global|\.gop|\.graphics|\.green|\.gripe|\.guide|\.guitars|\.guru|\.healthcare|\.help|\.here|\.hiphop|\.hiv|\.holdings|\.holiday|\.homes|\.horse|\.host|\.hosting|\.house|\.how|\.info|\.ing|\.ink|\.institute|\.insure|\.international|\.investments|\.jobs|\.kim|\.kitchen|\.land|\.lawyer|\.legal|\.lease|\.lgbt|\.life|\.lighting|\.limited|\.limo|\.link|\.loans|\.lotto|\.luxe|\.luxury|\.management|\.market|\.marketing|\.media|\.meet|\.meme|\.memorial|\.menu|\.mobi|\.moe|\.money|\.mortgage|\.motorcycles|\.mov|\.museum|\.name|\.navy|\.network|\.new|\.ngo|\.ninja|\.one|\.ong|\.onl|\.ooo|\.organic|\.partners|\.parts|\.party|\.pharmacy|\.photo|\.photography|\.photos|\.physio|\.pics|\.pictures|\.pink|\.pizza|\.place|\.plumbing|\.poker|\.porn|\.post|\.press|\.pro|\.productions|\.prof|\.properties|\.property|\.qpon|\.recipes|\.red|\.rehab|\.ren|\.rentals|\.repair|\.report|\.republican|\.rest|\.reviews|\.rich|\.rip|\.rocks|\.rodeo|\.rsvp|\.sale|\.science|\.services|\.sexy|\.shoes|\.singles|\.social|\.software|\.solar|\.solutions|\.space|\.supplies|\.supply|\.support|\.surf|\.surgery|\.systems|\.tattoo|\.tax|\.technology|\.tel|\.tips|\.tires|\.today|\.tools|\.top|\.town|\.toys|\.trade|\.training|\.travel|\.university|\.vacations|\.vet|\.video|\.villas|\.vision|\.vodka|\.vote|\.voting|\.voyage|\.wang|\.watch|\.webcam|\.website|\.wed|\.wedding|\.whoswho|\.wiki|\.work|\.works|\.world|\.wtf|\.xxx|\.xyz|\.yoga|\.zone)/i', '', $string);
	$replace = trim($replace, ' ');
	return $replace;
}

/* GET ROOT PATH */

function the_root() {
	$root = $_SERVER['DOCUMENT_ROOT'];
	return $root;
}

function encode64($str) {
	return base64_encode($str);
}

function decode64($str) {
	return base64_decode($str);
}


?>