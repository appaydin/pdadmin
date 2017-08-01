<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Utils;

use Symfony\Component\HttpFoundation\Request;

/**
 * pdAdmin Utility
 *
 * @package AdminBundle\Utils
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class Utility
{
    /**
     * Get Request Format
     *
     * @param Request $request
     * @return string
     */
    public function getRequestFormat(Request $request)
    {
        /**
         * Get Format Header
         */
        switch ($request->headers->get('Content-Type')) {
            case 'application/json':
                $requestType = 'json';
                break;
            case 'application/xml':
                $requestType = 'xml';
                break;
            case 'text/xml':
                $requestType = 'xml';
                break;
            default :
                $requestType = "json";
        }

        /**
         * Set Custom Router _format
         */
        if (in_array($request->getRequestFormat(), ['xml', 'json'])) {
            $requestType = $request->getRequestFormat();
        }

        return $requestType;
    }
}