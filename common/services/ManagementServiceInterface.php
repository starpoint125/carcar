<?php
namespace common\services;

interface ManagementServiceInterface extends ServiceInterface
{
    const ServiceName = 'managementService';
    public function getRecentComments($limit = 10);
    public function getCarCountByPeriod($startAt=null, $endAt=null);
}