<?php

$path = $_SERVER['PATH_INFO'];


if ($path = '/address')
{
  $controller = new \Controller();
  $return = $controller->ex();
  echo $return;
}

class Controller
{
  protected $addresses = [];

  function ex()
  {
    $this->rcd();
    $id = $_GET['id'];
    $address = $this->addresses[$id];
    return json_encode($address);
  }

  function rcd()
  {
    $file = fopen('turbines.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        $this->addresses[] = [
            $line[0],
            $line[1],
            $line[2]
        ];
    }

    fclose($file);
  }
}
?>
