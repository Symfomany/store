<?php

namespace Store\BackendBundle\Twig\Extensions;

/**
 * Class StoreBackendExtension
 * @package Store\BackendBundle\Twig\Extension
 */
class StoreBackendExtension extends \Twig_Extension
{
    /**
     * FOnction qui me retourne tous mes filtres crée
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

        );
    }
    /**
     * State helper
     * @param $state
     * @return string
     */
    public function state($state){
        if($state == 2){
            $badge =  "<span class='label label-success'>Envoyé</span>";
        }elseif($state == 1){
            $badge =  "<span class='label label-info'>En cours</span>";
        }
        else{
            $badge =  "<span class='label label-warning'>Annulé</span>";
        }

        return $badge;
    }






















    /**
     * @param null $picture
     * @param string $size
     * @return string
     */
    public function thumb($picture = null, $size = 'thumb')
    {
        if ($picture == null)
            return '';
        $parts = explode('.', $picture);
        $name = $parts[count($parts) - 2];
        $ext = $parts[count($parts) - 1];
        return $name . '-' . $size . '.' . "jpeg";
    }

    public function getQRCode($id){

        return "<iframe src='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=http%3A//symfony.3wa.fr/movies/3/pdf&chld=H|0'
'></iframe>";
    }

    /**
     * Format a price
     * @param $number
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @return string
     */
    public function price($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$' . $price;

        return $price;
    }


    /**
     * Created ago function
     * @param $dateTime
     * @return null|string
     * @throws \Exception
     */
    public function createdAgo($dateTime)
    {

        if (!$dateTime)
            return null;

        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \Exception("createdAgo is unable to handle dates in the future");
        $duration = "";
        if ($delta < 60) {
            // Seconds
            if ($delta < 60) {
                // Secondes
                $time = $delta;
                $duration = $time . " seconde" . (($time === 0 || $time > 1) ? "s" : "") . "";
            }
        } else if ($delta <= 3600) {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "") . "";
        } else if ($delta <= 86400) {
            // Hours
            $time = floor($delta / 3600);
            $duration = $time . " heure" . (($time > 1) ? "s" : "") . "";
        } else {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " jour" . (($time > 1) ? "s" : "") . "";
        }
        return $duration;
    }


    /**
     * Begin in function
     * @param \DateTime $dateTime
     * @return null|string
     */
    public function beginIn(\DateTime $dateTime)
    {
        if (!$dateTime)
            return null;

        $delta = time() - $dateTime->getTimestamp();

        $duration = "";
        if ($delta > 60) {
            // Seconds
            if ($delta > 60) {
                // Secondes
                $time = $delta;
                $duration = abs($time) . " seconde" . ((abs($time) === 0 || abs($time) > 1) ? "s" : "") . "";
            }
        } else if ($delta >= 3600) {
            // Mins
            $time = floor($delta / 60);
            $duration = abs($time) . " minute" . ((abs($time) > 1) ? "s" : "") . "";
        } else if ($delta >= 86400) {
            // Hours
            $time = floor($delta / 3600);
            $duration = abs($time) . " heure" . ((abs($time) > 1) ? "s" : "") . "";
        } else {
            // Days
            $time = floor($delta / 86400);
            $duration = abs($time) . " jour" . ((abs($time) > 1) ? "s" : "") . "";
        }
        return $duration;
    }



    /**
     * URL Decode a string
     * @param string $url
     * @return string The decoded URL
     */
    public function urlDecode($url)
    {
        return urldecode($url);
    }


    /**
     * Get period between 2 dates
     * @param $begin
     * @param $end
     * @param int $daysInterval
     * @return \DatePeriod
     */
    public function datePeriod($begin, $end, $daysInterval = 1)
    {
        # Dates : String pour DateTime::modify or DateTime directly
        if (is_string($begin))
            $begin = new \Datetime($begin);
        else
            $dateBegin = $begin;

        $dateEnd = clone $dateBegin;
        if (is_string($end))
            $dateEnd->modify($end);
        else
            $dateEnd = $end;

        # Interval
        $interval = new \DateInterval("P" . $daysInterval . "D");

        # Periode
        $period = new \DatePeriod($dateBegin, $interval, $dateEnd);

        return $period;
    }


    /**
     * JSON decode
     * @param $val
     * @return mixed
     */
    public function jsonDecode($val)
    {
        return json_decode($val);
    }

    /**
     * Get name of my extension
     * @return string
     */
    public function getName()
    {
        return 'store_backend_extension';
    }
}
