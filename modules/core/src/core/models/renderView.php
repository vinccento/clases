<?php

function renderView($request, $config, $data=null)
{
    /*
    echo"<pre> request ";
    print_r($request);
    echo"<pre>";
    
    
    
    echo"<pre> config ";
    print_r($config);
    echo"<pre>";
    
    echo"<pre> data ";
    print_r($data);
    echo"<pre>";
    
    
    $controller = explode('\\', $request['controller']);
    echo"<pre> controller ";
    print_r($controller);
    echo"<pre>";
    
    
    echo $config['view_path']."/".$controller[2]."/".$request['action'].".phtml";
    

    die;
    
    */
    
    $controller = explode('\\', $request['controller']);
    
    ob_start();
        include ($config['view_path']."/".
                 $controller[2]."/".
                 $request['action'].".phtml");
        
        $content = ob_get_contents();
    ob_end_clean();
    
    return $content;
}