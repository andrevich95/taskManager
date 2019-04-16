<?php

namespace Core\Http;

class Request{

    /** @var array|null */
    private $_post;

    /** @var array|null */
    private $_get;

    /** @var string */
    private $_url;

    /** @var string */
    private $_method;

    /** @var string */
    private $_cookie;

    /** @var User */
    private $_user;

    /**
     * @return User
     */
    public function user()
    {
        return $this->_user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return array|null
     */
    public function paramsPost()
    {
        return $this->_post;
    }

    /**
     * @return array|null
     */
    public function paramsGet()
    {
        return $this->_get;
    }

    /**
     * @return string
     */
    public function url()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function method()
    {
        return $this->_method;
    }

    /**
     * Request constructor.
     */
    public function __construct(){
        $this->_url = isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI'])[0] : '/';
        $this->_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $this->_post = !empty($_POST) ? $_POST : null;
        $this->_get = !empty($_GET) ? $_GET : null;
        $this->_cookie = isset($_COOKIE['user_session_id']) ? $_COOKIE['user_session_id'] : null;
        $this->_user = null;
    }

    /**
     * @return string
     */
    public function getCookie()
    {
        return $this->_cookie;
    }

    /**
     * @param string $cookie
     */
    public function setCookie($cookie)
    {
        setcookie('user_session_id', $cookie,time() + 100000);
    }


}