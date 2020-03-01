<?php defined("C5_EXECUTE") or die("Access Denied.");
$link = false;
if (!empty($page) && ($page_c = Page::getByID($page)) && (!empty($page_c) || !$page_c->error)) {
	$link = $page_c->getCollectionLink();
	$target = '_self';
} elseif (isset($url)){
	$link = strpos($url,'http') === 0  ? $url : 'http://'.$url;
	$target = '_blank';
} elseif (isset($file_1) && $file_1 !== false) {
	$link = isset($file_1->urls["download"]) ? $file_1->urls["download"] : $file_1->urls["relative"];
	$target = '_blank';
}
?>

<div class="plain">
    <div class="plainTitle">
        <a href="<?php echo $link ?>" target="<?= $target ?>">
			<?php if (isset($title) && trim($title) != "") {
				echo $title;
			} ?>
        </a>
    </div>
    <div class="plainBlurb">
        <?= $blurb ?>
    </div>
    <div class="plainMore">
        <a href="<?php echo $link ?>" target="<?= $target ?>">&nbsp;</a>
    </div>
</div>