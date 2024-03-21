<?php

namespace Codelab\Teams\Exceptions;

use Exception;

class MemberNotFoundException extends Exception {
    /**
     * The default error message.
     */
    protected $message = "Could not find the specified member.";
}