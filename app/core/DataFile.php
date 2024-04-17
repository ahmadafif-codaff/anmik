<?php

class DataFile{

    public static function get($file){
        return json_decode(file_get_contents($file));
    }

    private static function write($file, $txt){
        $myfile = fopen($file, "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public static function usage($upload, $download, $client, $save='no'){
        $old = self::get('db/usage.json');
        // var_dump($old);
        if($save=='yes'){
            $txt = "[\n";
            $txt .= '{"id_usages":"'.(count($old)+1).'","time":"'.date('Y-m-d H:i:s').'","upload":"'.$upload.'","download":"'.$download.'","id_client":"'.$client.'"}';
            if(count($old)>0){
                $txt .= ",\n";
            }else{
                $txt .= "\n";
            }
            for($x=0; $x<count($old); $x++){
                $txt .= '{"id_usages":"'.$old[$x]->id_usages.'","time":"'.$old[$x]->time.'","upload":"'.$old[$x]->upload.'","download":"'.$old[$x]->download.'","id_client":"'.$old[$x]->id_client.'"}';
                if($x!=(count($old)-1)){
                    $txt .= ",\n";
                }else{
                    $txt .= "\n";
                }
            }
            $txt .= "]";
        }else{
            $txt = '[{"id_usages":"'.(count($old)+1).'","time":"'.date('Y-m-d H:i:s').'","upload":"'.$upload.'","download":"'.$download.'","id_client":"'.$client.'"}]';
        }

        self::write('db/usage.json', $txt);
    }
}

?>