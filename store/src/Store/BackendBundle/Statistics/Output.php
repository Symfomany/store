<?php

namespace Store\BackendBundle\Statistics;

/**
 * Interface Output
 * @package Store\BackendBundle\Statistics
 */
interface Output{

    /**
     * Rendering in format
     * @param $data
     * @return mixed
     */
    public function render($data);

    /**
     * Export for HTTP|CLI
     * @return mixed
     */
    public function export();



}