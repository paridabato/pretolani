<?php

namespace App\Interfaces;

interface ICpts
{
    /**
     * Define CPTs associated models.
     * 'cpt-wp-key' => 'Model\Class
     */
    const MODELS = [
        'formation' => 'App\Models\Formation',
        'etude-de-cas' => 'App\Models\EtudeDeCas',
    ];
}
