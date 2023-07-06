<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactReq;
use App\Http\Sql;

function getmsgs($mail){
    
    $convs = Sql::query("
            SELECT * FROM
                (
                    SELECT contact.id,readed,content,id_contacted,users.mail as mail_contacted 
                    FROM contact 
                    INNER JOIN 
                        users 
                    ON 
                    contact.id_contacted = users.id
                ) as contacted
            INNER JOIN
                (
                    SELECT contact.id,readed,content,id_contactor,users.mail as mail_contactor,time 
                    FROM contact 
                    INNER JOIN 
                        users 
                    ON 
                        contact.id_contactor = users.id
                ) as contactor

            ON contacted.id = contactor.id 

            WHERE 
                contacted.mail_contacted = :mail 
            OR 
                contactor.mail_contactor = :mail

            ORDER BY contacted.id 
        ", [
            "mail" => $mail
        ]);

        return $convs;
}


class Contact extends Controller {


    public function id2mail($mail){

        $id = Sql::query(
            "SELECT id FROM users WHERE mail=:mail",
            [ "mail" => $mail ]
        );

        return $id;
    }

    public function mark_readed($id){

        Sql::query("
            UPDATE contact 
            SET 
                readed = 1 
            WHERE 
                id_contacted = :me 
            AND
                id_contactor = :he
            AND 
                readed = 0
        ", [
            "me" => $_SESSION["id"],
            "he" => $id,
        ]);

    }


    public function show($slug = false){
        
        $exploitable_data = [];

        foreach(getmsgs($_SESSION["mail"]) as $data){

            # Create time at hand 
            $time = explode("-", explode(" ", $data["time"])[0])[2] . " " . strtolower(date('F', mktime(0, 0, 0, explode("-", $data["time"])[1], 10))) . ", " . implode(":", array_slice(explode(":", explode(" ", $data["time"])[1]), 0, 2));

            # Then the contactor is the current user
            if($data["mail_contacted"] === $_SESSION["mail"]){

                                
                $mail = $data["mail_contactor"];
                $toput = [ 
                    $data['content'], 
                    "me" => false, 
                    "id" => $data["id"],
                    "time" => $time
                ];
            } 

            # Then the contactor is the other user
            else {
                $mail = $data["mail_contacted"];
                $toput = [ 
                    $data['content'], 
                    "me" => true, 
                    "id" => $data["id"],
                    "time" => $time
                ];
            }


            if(isset($exploitable_data[$mail])){
                array_push($exploitable_data[$mail], $toput);
            }
            else {
                $exploitable_data[$mail] = [ $toput ];
            }
        }

        
        if($slug){

            if($slug === $_SESSION["mail"]){
                $_SESSION["contact_yourself"] = true;
                return redirect(route("contact"));  
            }

            $id = Contact::id2mail($slug);

            if(empty($id))
                return abort(404);
            else 
                $id = $id[0]["id"];

            Contact::mark_readed($id);

            return view("user.contact", [ "noone" => false, "user" => $slug, "data" => $exploitable_data ]);

        }   

        else {
            return view("user.contact", [ "noone" => true, "data" => $exploitable_data ]);
        }
    }


    public function store(ContactReq $req){

        $url = explode("/contact/", url() -> previous());
        
        if(!isset($url[1])){
            return abort(403);
        }
        $mail = $url[1];
        

        $id = Sql::query(
            "SELECT id FROM users WHERE mail=:mail",
            ["mail" => $mail]
        );
        
        if(empty($id)){
            $_SESSION["contact_no_one"] = true;
            return redirect("/contact");
        }

        Sql::query("
            INSERT INTO 
                contact(
                    readed, id_contactor, id_contacted, content, time
                ) 
            VALUES (
                    FALSE, :id_contactor, :id_contacted, :content, :time
                )
        ", [
            "id_contactor" => $_SESSION["id"],
            "id_contacted" => $id[0]['id'],
            "content" => $req["content"],
            "time" => date('Y-m-d H:i:s')
        ]);

        return redirect(route("contactuser", $mail));
    }


    public function delete($slug){

        Sql::query("
            DELETE FROM contact 
            WHERE 
                id=:slug 
            AND 
                id_contactor=:user
        ", [
            "slug" => $slug,
            "user" => $_SESSION["id"]
        ]);

        return redirect(url() -> previous());
    }
}
