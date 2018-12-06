<!DOCTYPE html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
</head>
<form method="post">
    <!--<label>Id</label>
    <input type="text" name="id">
    <br><br>-->
    <label>Url</label>
    <input type="text" name="url" size="255">
    <br><br>
    <input type="submit">
    <br><br>
</form>
</html>

<?php

class Index
{
    protected $imageSize;

    public function replace()
    {
        $string = $_POST['url'];
        $word = 'tag=amairo-20&camp=1789';
        $replace = 'tag={{tag}}&camp={{camp}}';
        return str_replace($word, $replace, $string);
    }

    public function resizeImg()
    {
        //$string = $_POST['img'];
        $string = $this->imageSize;
        $word = '_SS500';
        $replace = '_SS100';
        return str_replace($word, $replace, $string);
    }

    public function getAsin()
    {
        $string = $_POST['url'];
        $url = parse_url($string);
        $word = array('/ref=as_li_tl', '/gp/product/');
        $replace = '';
        $url = str_replace($word, $replace, $url['path']);
        return $url;
    }

    public function getByAsing()
    {
        $url = file_get_contents($_POST['url']);
        @$doc = new DOMDocument();
        @$doc->loadHTML($url);
        $domXpath = new DOMXPath($doc);
        $title = $domXpath->query('//*[@class="a-size-large a-spacing-micro"]')->item(0);
        echo '<input id="asin" size="255" value="' .$title->nodeValue. '">';
        echo '<br>';
        $author = $domXpath->query('//*[@class="a-size-medium a-link-normal"]')->item(0);
        echo '<input id="asin" size="255" value="' .$author->nodeValue. '">';
        echo '<br>';
        $img = $domXpath->query('//div[@id="coverArt_feature_div"]/img')->item(0);
        $this->imageSize = $img->getAttribute('src');

        $songType = $domXpath->query('//div[@class="a-section a-spacing-none a-padding-none DigitalBuyButtonSection DigitalBuyButtonBuyBoxSection"]/span/span/a')->item(0);
        if (strpos($songType->nodeValue, 'song')) {
            echo 'song';
        } elseif (strpos($songType->nodeValue, 'Album')) {
            echo 'album';
        }
    }

}

$index = new Index();
$index->getByAsing();
echo '<br>';
echo '<input id="asin" size="255" value="' . $index->getAsin() . '">';
//echo '<button class="btn" data-clipboard-target="#asin">Copy</button>';
echo '<br>';
echo '<input id="asin" size="255" value="' .$index->resizeImg(). '">';
echo '<br>';
echo '<input id="asin" size="255" value="' .$index->replace() . '">';


?>

