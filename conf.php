<?php
$kasutaja='opilane';
$serverinimi='localhost';
$parool='123';
$andmebaas='veronika';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
