<?php

class QtApi{
    private $key = null;
    private $error = false;

    public function __construct($key = null){
        if(!empty($key)){
            $this->key = $key;
        }
            
    }
    /*
    request()
    determina d url concatenando com o endpoint da api a ser usado
    concatenando com minha key de acesso a api publica, com o formato json
    
    */

    public function request($endpoint = '', $params = array()){
        $url = 'https://api.hgbrasil.com/'. $endpoint. '?key='.$this->key .'&format=json';

        if(is_array($params)){
            foreach($params as $key => $value){
                if(empty($value)) continue;
              $url .= $key . '=' . urlencode($value). '&';
                }
               $url = substr($url, 0, -1); 
               $response = @file_get_contents($url); 
               $this->error = false;
               return json_decode($response, true);

        } else{

            $this->error = true;
            return false;
        
        }

    }

    public function is_error(){
        return $this->error;
    }

    /*
    cotDolar()
    função pra chamar os dados a ser consumidos na api
    usando a cotação do Euro disponiblizado.
    */
    public function CotDolar(){
        //fazendo request da URN (setar os serviços a serem usados)
        $data = $this->request('finance/quotations');
        if(!empty($data) && is_array($data['results']['currencies']['USD'])){
            $this->error = false;
            return $data['results']['currencies']['USD'];
        } else {
            $this->error = true;
            return false;
        }
    }

    
    /*
    função pra chamar os dados a ser consumidos na api
    usando a cotação do Euro disponiblizado.
    */

    public function CotEuro(){
        $data = $this->request('finance/quotations');
        if(!empty($data) && is_array($data['results']['currencies']['EUR'])){
            $this->error = false;
            return $data['results']['currencies']['EUR'];
        } else {
            $this->error = true;
            return false;
        }
    }

}

