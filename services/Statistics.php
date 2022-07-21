<?php

namespace app\services;

use app\models\Url;

class Statistics
{
    /**
     * Статтистика переходов по ссылке
     * @param Url $url
     * @return array
     */
    public static function get(Url $url): array
    {
        $data = [];
        $visits = $url->getVisits()->select('created_at')->limit(5000)->column();
        foreach ($visits as $createdAt) {
            $date = date('d.m.Y', $createdAt);
            if (!isset($data[$date])) {
                $data[$date] = 1;
            } else {
                $data[$date] += 1;
            }
        }
        return $data;
    }
}