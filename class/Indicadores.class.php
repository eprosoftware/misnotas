<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class Indicadores {
        function setValores(){
            $apiUrl = 'http://mindicador.cl:80/api';
            //Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
            if ( ini_get('allow_url_fopen') ) {
                $json = file_get_contents($apiUrl);
            } else {
                //De otra forma utilizamos cURL
                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                curl_close($curl);
            }

            $dailyIndicators = json_decode($json);
            $this->setUf($dailyIndicators->uf->valor);
            $this->setDolar($dailyIndicators->dolar->valor);
            //echo 'El valor actual del Dólar acuerdo es $' . $dailyIndicators->dolar_intercambio->valor;
            $this->setEuro($dailyIndicators->euro->valor);
            $this->setIpc($dailyIndicators->ipc->valor);
            $this->setUtm($dailyIndicators->utm->valor);
            //echo 'El valor actual del IVP es $' . $dailyIndicators->ivp->valor;
            $this->setImacec($dailyIndicators->imacec->valor);              
        }
        function setDolar($x)   {$this->dolar = $x;}
        function setEuro($x)    {$this->euro = $x;}
        function setUf($x)      {$this->uf= $x;}
        function setUtm($x)     {$this->utm=$x;}
        function setIpc($x)     {$this->ipc=$x;}
        function setImacec($x)  {$this->imacec=$x;}
        
        function getDolar() {return $this->dolar;}
        function getEuro()  {return $this->euro;}
        function getUf()    {return $this->uf;}
        function getUtm()   {return $this->utm;}
        function getIpc()   {return $this->ipc;}
        function getImacec(){return $this->imacec;}        
    }

