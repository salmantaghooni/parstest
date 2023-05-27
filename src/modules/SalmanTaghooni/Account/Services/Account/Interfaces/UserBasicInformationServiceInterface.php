<?php

namespace SalmanTaghooni\Account\Services\Account\Interfaces;


interface UserBasicInformationServiceInterface
{
    public function index();
    public function store($request);
    public function update($request);
}
