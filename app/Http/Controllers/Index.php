<?php

namespace App\Http\Controllers;

class Index extends Controller {
    
    public function __invoke(){
        
        include_once __DIR__ . '/../../Database/config.php';

        $products = $pdo -> query("SELECT * FROM `products` ORDER BY id DESC");
        $data = $products -> fetchAll();
        return view("index", ["data" => $data]);

    }
}

