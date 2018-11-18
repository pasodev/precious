<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 08/11/2018
 * Time: 11:23
 */

namespace App\Crawler;

interface CrawlerInterface
{
    public function setUrl($url);
    public function getHtml();
    public function setSections();
    public function getSections();
    public function getProducts();
    public function getProduct($productName);


}