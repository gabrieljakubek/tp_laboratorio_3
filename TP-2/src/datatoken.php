<?php
class DataToken
{
    public $email;
    public $tipo;
    public function __construct($email, $tipo)
    {
        $this->email = $email;
        $this->tipo = $tipo;
    }
}
