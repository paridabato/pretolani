<?php

namespace App\Classes;

class GDPR
{
    private static $constants = [
        'bar'   => [
            // Style of Bar
            'cube'  => false,
            'explanation' => "Ce site utilise des cookies fonctionnels et des scripts externes pour améliorer votre expérience. Les cookies et scripts utilisés et leur impact sur votre visite sont spécifiés à gauche. Vous pouvez modifier vos paramètres à tout moment. Vos choix n'auront pas d'impact sur votre visite.",
            'buttons' => ['Paramètres', 'Accepter']
        ],
        'modal' => [
            'title'         => 'Paramètres de confidentialité',
            'description'   => 'Afin de faciliter votre navigation et de vous apporter le meilleur service possible, nous utilisons des cookies pour améliorer le site aux besoins des visiteurs, notamment selon la fréquentation.',
            'privacy_text'  => 'Nos politique de confidentialité',
            'buttons'        => ['Accepter', 'Refuser']
        ]
    ];

    private static $consents = [
        'recaptcha' => [
            'title'         => 'Recaptcha',
            'description'   => '',
            'required'  => true,
            'opout'     => false
        ],
        'analytics' => [
            'title'         => 'Analytics',
            'description'   => '',
            'required'  => false,
            'opout'     => true
        ]
    ];

    public static function getConstants()
    {
        return self::$constants;
    }

    public static function getConsents()
    {
        return self::$consents;
    }

    public static function getId()
    {
        return hash('sha256', serialize(self::getConsents()));
    }

    public static function getIsByPass()
    {
        return isset($_GET['gdpr']) && $_GET['gdpr'] == GDPR_BY_PASS;
    }
}
