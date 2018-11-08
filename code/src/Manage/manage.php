<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 08/11/2018
 * Time: 11:38
 */

include '../Crawler/GenericCrawler.php';


$crawler = new \Crawler\GenericCrawler();

$crawler->setUrl('google.com');
echo var_dump($crawler->setHtml()->getHtml());
