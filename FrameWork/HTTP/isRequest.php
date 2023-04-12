<?php

namespace FrameWork\HTTP;

/**
 * @webTech2:
 *
 *  @INHLUD:
 *          Binnen deze klasse is er een static method.
 *          De bedoeling van deze method @gpost() om een boolean terug te geven waanneer er een sprake is van een post request.
 *  @GEBRUIK: dit wordt gebruik vaak bij elke controller wannneer er een handiling van een post request plaats vindt.
 *
 */

class isRequest
{

    /**
     * @return bool
     */
    public static function post(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }


}