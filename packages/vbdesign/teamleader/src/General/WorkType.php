<?php

namespace Vbdesign\Teamleader\General;

/**
 * TeamLeader Laravel PHP SDK.
 *
 * @version    1.0.0
 *
 * @copyright  Copyright (c) 2018 Invato B.V. (https://invato.nl)
 * @author     Geert Lucas Drenthe <gl@drenthe.it>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-3.txt    LGPL
 */
class WorkType
{
    private $teamleader;

    public function __construct($teamleader)
    {
        $this->setTeamleader($teamleader);
    }

    /**
     * set Teamleader.
     *
     * @param $teamleader
     */
    public function setTeamleader($teamleader)
    {
        $this->teamleader = $teamleader;
    }

    /**
     * get Teamleader.
     */
    public function getTeamleader()
    {
        return $this->teamleader;
    }

    /**
     * Get a list of work types.
     */
    public function list($data = [])
    {
        return $this->teamleader->getCall('workTypes.list?'.http_build_query($data));
    }
}
