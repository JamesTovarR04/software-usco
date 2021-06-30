<?php

namespace App\Helpers;

class HTTPRequest
{
    var $_fp;        // HTTP socket
    var $_url;        // full URL
    var $_host;        // HTTP host
    var $_protocol;    // protocol (HTTP/HTTPS)
    var $_uri;        // request URI
    var $_port;        // port

    // constructor
    public function __construct($url)
    {
        $this->_url = $url;
        $this->_scan_url();
    }
   
    // scan url
    private function _scan_url()
    {
        $req = $this->_url;
       
        $pos = strpos($req, '://');
        $this->_protocol = strtolower(substr($req, 0, $pos));
       
        $req = substr($req, $pos+3);
        $pos = strpos($req, '/');
        if($pos === false)
            $pos = strlen($req);
        $host = substr($req, 0, $pos);
       
        if(strpos($host, ':') !== false)
        {
            list($this->_host, $this->_port) = explode(':', $host);
        }
        else
        {
            $this->_host = $host;
            $this->_port = ($this->_protocol == 'https') ? 443 : 80;
        }
       
        $this->_uri = substr($req, $pos);
        if($this->_uri == '')
            $this->_uri = '/';
    }
   
    // download URL to string
    public function DownloadToString()
    {
        $crlf = "\r\n";

        error_reporting(E_ALL ^ E_WARNING);
       
        // fetch
        $this->_fp = fsockopen(($this->_protocol == 'https' ? 'ssl://' : '') . $this->_host, $this->_port, $errno, $errstr, 30);
        
        if (!$this->_fp) {
            //echo "ERROR: $errstr ($errno)\n";
            return "";
        }else{

            //send the server request 
            fputs($this->_fp, "POST $this->_uri HTTP/1.1" . $crlf);
            fputs($this->_fp, "Host: $this->_host" . $crlf);
            fputs($this->_fp, "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8" . $crlf);
            fputs($this->_fp, "Connection: close\r\n\r\n");

            // generate request
            $response = "";

            while(!feof($this->_fp))
                $response .= fgets($this->_fp, 4093);

            fclose($this->_fp);

            // split header and body
            $pos = strpos($response, $crlf . $crlf);
            if($pos === false)
                return($response);
            $header = substr($response, 0, $pos);
            $body = substr($response, $pos + 2 * strlen($crlf));

            return($body);

        }
       
    }

    public static function getStudentProgram ($corte, $codigo) {

        $url = 'https://gaitana.usco.edu.co/liquidacion/liqui_ant_resul_bar2006.jsp';
        $estampa = time()."000";
        $url .= "?estampa=$estampa&PERIODO=$corte&CODIGO=$codigo";
    
        $resource = new HTTPRequest($url);
        $str_pagina = $resource->DownloadToString();
    
        // Cortar string a las etiquetas donde se encuentra la información del programa
        $str_pagina = substr($str_pagina,strpos($str_pagina,'<TD colspan=1>'));
        $str_pagina = substr($str_pagina,0,strpos($str_pagina,'</TD>') + 5);
    
        // Eliminar etiquetas y saltos de linea
        return strip_tags(preg_replace("/[\r\n|\n|\r|\t]+/", "", $str_pagina));
    
    }

}