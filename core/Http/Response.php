<?php

namespace Core\Http;

class Response{

    /** @var array */
    private $_headers;

    /** @var string */
    private $_body;

    /** @var integer */
    private $_status;

    /**
     * @param $content
     * @return Response
     */
    public function html($content){
        $this->_headers[] = ['Content-type' => 'text/html; charset=utf-8'];
        return $this->body($content);
    }

    /**
     * @param $content
     * @return Response
     */
    public function json($content){
        $this->_headers[] = ['Content-type' => 'application/json; charset=utf-8'];
        if(is_array($content)) $content = json_encode($content);
        return $this->body($content);
    }

    /**
     * @param $url
     */
    public function redirect($url){
        header('Location: '. $url);
    }

    /**
     * @param $body
     * @return $this
     */
    public function body($body){
        $this->_body = $body;
        return $this;
    }

    /**
     * @param $status
     * @return $this
     */
    public function status($status){
        $this->status($status);
        return $this;
    }


    public function send(){
        http_response_code($this->_status);
        foreach ($this->_headers as $name => $header){
            header($name . ':' . $header);
        }
        echo $this->_body;
    }

}