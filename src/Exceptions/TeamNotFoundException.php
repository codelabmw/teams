<?php

namespace Codelab\Teams\Exceptions;

use Exception;

class TeamNotFoundException extends Exception
{
    /**
     * Default error message
     */
    protected $message = "Could not find the specified team.";
}