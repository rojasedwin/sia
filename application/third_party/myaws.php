<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myaws
{
    public function __construct()
    {
        require_once dirname(__FILE__) . '/aws/aws-autoloader.php';
    }
}
