<?php
namespace App\Repositories;

interface EventInterface
{
    public function createEvent($request);
    public function listEvents();
}