<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComments;
use App\Http\Requests\UpdateComment;

class Comments extends Controller {

    public function store(StoreComments $req){
        
        $pdo = config("app.pdo");

        $add_comment = $pdo -> prepare("
            INSERT INTO comments
                (`id_product`, `id_user`, `title`, `content`, `writed_at`, `rating`)
            VALUES
                (:id_product, :id_user, :title, :comment, :writed_at, :rating)
        ");

        $add_comment -> execute([
            "id_product" => $req["id"], 
            "writed_at" => date('Y-m-d H:i:s'),
            "id_user" => $_SESSION['id'],
            "title" => $req['title'],
            "comment" => htmlspecialchars($req["comment"]),
            "rating" => $req["rating"],
        ]);

        $_SESSION['done'] = true;

        return redirect(route("details", $req["id"]));
    }


    public function get($id){
        
        $pdo = config("app.pdo");

        $get_comments = $pdo -> prepare("
            SELECT 
                comments.id, rating, id_product,
                content, writed_at, mail, title

            FROM comments
            INNER JOIN users 
            ON 
                users.id=comments.id_user
    
            WHERE 
                id_product=:id
        
            ORDER BY writed_at DESC
        ");
        
        $get_comments -> execute([
            "id" => $id
        ]);


        $data = $get_comments -> fetchAll(\PDO::FETCH_ASSOC);

        if(empty($data)){
            return abort(404);
        }

        return ($data);
    }

    
    public function delete($article, $id){

        $pdo = config("app.pdo");

        $delete_comment = $pdo -> prepare("
            DELETE FROM comments 
            WHERE 
                id=:id 
            AND 
                id_user=:id_user
        ");
        
        $delete_comment -> execute([
            "id_user" => $_SESSION["id"],
            "id" => $id
        ]);

        return redirect(route("details", $article));
    }


    public function get_update_form($slug){
        $pdo = config("app.pdo");
        
        $get_comment = $pdo -> prepare("
            SELECT * FROM comments 
            WHERE 
                id_user=:id_user
            AND 
                id=:id 
        ");

        $get_comment -> execute([
            "id_user" => $_SESSION["id"],
            "id" => $slug
        ]);

        $data = $get_comment -> fetch(\PDO::FETCH_ASSOC);

        if(empty($data)){
            return abort(403);
        }
        else {
            return view("user.updatecomment", [ "data" => $data ]);
        }
    }


    public function update(UpdateComment $req){

        if($req["abort"] === "Abort"){
            return redirect(route("details", $req["id_product"]));
        }
        $pdo = config("app.pdo");

        $update_comment = $pdo -> prepare("
            UPDATE comments
            SET 
                `title` = :title , 
                `content` = :comment, 
                `writed_at` = :writed_at, 
                `rating` = :rating

            WHERE
                `id_user` = :id_user          
            AND 
                `id` = :id
        ");

        $update_comment -> execute([
            "id" => $req["id"], 
            "writed_at" => date('Y-m-d H:i:s'),
            "id_user" => $_SESSION['id'],
            "title" => $req['title'],
            "comment" => htmlspecialchars($req["comment"]),
            "rating" => $req["rating"],
        ]);

        $_SESSION['updated'] = true;

        return redirect(route("details", $req["id_product"]));

    }
}
