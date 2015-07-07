<?php

namespace Store\BackendBundle\Twig\Extensions;

/**
 * Class StoreBackendExtension.
 */
class StoreBackendExtension extends \Twig_Extension
{
    /**
     * FOnction qui me retourne tous mes filtres crée.
     *
     * @return array
     */
    public function getFilters()
    {
        //retourne un tableau de filtre crée
        return array(
            // Twig_SimpleFilter :
            // - 1er argument est le nom du filtre en TWIG
            // - 2eme argument est le nom du filtre en TWIG
            new \Twig_SimpleFilter('state', array($this, 'state')),
            new \Twig_SimpleFilter('ago', array($this, 'ago')),
            new \Twig_SimpleFilter('begin', array($this, 'beginIn')),
            new \Twig_SimpleFilter('urldecode', array($this, 'urlDecode')),
            new \Twig_SimpleFilter('thumb', array($this, 'thumb')),
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),

        );
    }

    /**
     * @param null   $picture
     * @param string $size
     *
     * @return string
     */
    public function thumb($picture = null, $size = 'thumb')
    {
        if ($picture == null) {
            return '';
        }
        $parts = explode('.', $picture);
        $name = $parts[count($parts) - 2];
        $ext = $parts[count($parts) - 1];

        return $name.'-'.$size.'.'.'jpeg';
    }

    public function getQRCode($id)
    {
        return "<iframe src='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=http%3A//symfony.3wa.fr/movies/3/pdf&chld=H|0'
'></iframe>";
    }

    /**
     * Format a price.
     *
     * @param $number
     * @param int    $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return string
     */
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.' €';

        return $price;
    }

    public function pluralize($count, $text)
    {
        return $count.(($count == 1) ? (" $text") : (" ${text}s"));
    }

    public function ago($datetime)
    {
        $interval = date_create('now')->diff($datetime);

        if ($v = $interval->y >= 1) {
            return $this->pluralize($interval->y, 'année');
        }
        if ($v = $interval->m >= 1) {
            return $this->pluralize($interval->m, 'moi');
        }
        if ($v = $interval->d >= 1) {
            return $this->pluralize($interval->d, 'jour');
        }
        if ($v = $interval->h >= 1) {
            return $this->pluralize($interval->h, 'heure');
        }
        if ($v = $interval->i >= 1) {
            return $this->pluralize($interval->i, 'minute');
        }

        return $this->pluralize($interval->s, 'second');
    }

    /**
     * Begin in function.
     *
     * @param \DateTime $dateTime
     *
     * @return null|string
     */
    public function beginIn(\DateTime $dateTime)
    {
        if (!$dateTime) {
            return;
        }

        $delta = time() - $dateTime->getTimestamp();

        $duration = '';
        if ($delta > 60) {
            // Seconds
            if ($delta > 60) {
                // Secondes
                $time = $delta;
                $duration = abs($time).' seconde'.((abs($time) === 0 || abs($time) > 1) ? 's' : '').'';
            }
        } elseif ($delta >= 3600) {
            // Mins
            $time = floor($delta / 60);
            $duration = abs($time).' minute'.((abs($time) > 1) ? 's' : '').'';
        } elseif ($delta >= 86400) {
            // Hours
            $time = floor($delta / 3600);
            $duration = abs($time).' heure'.((abs($time) > 1) ? 's' : '').'';
        } else {
            // Days
            $time = floor($delta / 86400);
            $duration = abs($time).' jour'.((abs($time) > 1) ? 's' : '').'';
        }

        return $duration;
    }

    /**
     * URL Decode a string.
     *
     * @param string $url
     *
     * @return string The decoded URL
     */
    public function urlDecode($url)
    {
        return urldecode($url);
    }

    /**
     * Get period between 2 dates.
     *
     * @param $begin
     * @param $end
     * @param int $daysInterval
     *
     * @return \DatePeriod
     */
    public function datePeriod($begin, $end, $daysInterval = 1)
    {
        # Dates : String pour DateTime::modify or DateTime directly
        if (is_string($begin)) {
            $begin = new \Datetime($begin);
        } else {
            $dateBegin = $begin;
        }

        $dateEnd = clone $dateBegin;
        if (is_string($end)) {
            $dateEnd->modify($end);
        } else {
            $dateEnd = $end;
        }

        # Interval
        $interval = new \DateInterval('P'.$daysInterval.'D');

        # Periode
        $period = new \DatePeriod($dateBegin, $interval, $dateEnd);

        return $period;
    }

    /**
     * JSON decode.
     *
     * @param $val
     *
     * @return mixed
     */
    public function jsonDecode($val)
    {
        return json_decode($val);
    }
    /**
     * State helper.
     *
     * @param $state
     *
     * @return string
     */
    public function state($state)
    {
        if ($state == 8) {
            $badge = "<span class='label label-success'>Livré</span>";
        } elseif ($state == 7) {
            $badge = "<span class='label label-info'>En cours de paiement</span>";
        } elseif ($state == 6) {
            $badge = "<span class='label label-info'>En cours de livraison</span>";
        } elseif ($state == 5) {
            $badge = "<span class='label label-info'>En cours de préparation</span>";
        } elseif ($state == 4) {
            $badge = "<span class='label label-info'>En cours de réaprovisionnement</span>";
        } elseif ($state == 3) {
            $badge = "<span class='label label-info'>Erreur de paiement</span>";
        } elseif ($state == 2) {
            $badge = "<span class='label label-info'>Remboursé</span>";
        } elseif ($state == 1) {
            $badge = "<span class='label label-info'>Problème d'acheminement</span>";
        } else {
            $badge = "<span class='label label-warning'>Annulé</span>";
        }

        return $badge;
    }

    /**
     * Get name of my extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'store_backend_extension';
    }
}
