<?php

namespace SalmanTaghooni\Account\Services\Account\Interfaces;


interface NationalCardSerialInterface
{
    public function index();
    public function store($request);
    public function update($request);
}
