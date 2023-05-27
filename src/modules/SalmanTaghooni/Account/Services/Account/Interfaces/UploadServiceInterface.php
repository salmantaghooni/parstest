<?php

namespace SalmanTaghooni\Account\Services\Account\Interfaces;


interface UploadServiceInterface
{
    public function index();
    public function store($request);
    public function update($request);
}
