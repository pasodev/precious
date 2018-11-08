<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 08/11/2018
 * Time: 11:23
 */

namespace Crawler;

interface Crawler
{
    public function setUrl($url);
    public function getHtml();


}