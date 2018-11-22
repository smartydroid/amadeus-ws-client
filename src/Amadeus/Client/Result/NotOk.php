<?php
/**
 * amadeus-ws-client
 *
 * Copyright 2015 Amadeus Benelux NV
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package Amadeus
 * @license https://opensource.org/licenses/Apache-2.0 Apache 2.0
 */

namespace Amadeus\Client\Result;

/**
 * NotOk
 *
 * @package Amadeus\Client\Result
 * @author Dieter Devlieghere <dermikagh@gmail.com>
 */
class NotOk
{
    /**
     * Error/warning code
     *
     * @var mixed
     */
    public $code;

    /**
     * Message
     *
     * @var string
     */
    public $text;

    /**
     * Error/warning level
     *
     * @var string
     */
    public $level;

    /**
     * Source of error/warning
     *
     * @var string
     */
    public $source;

    /**
     * NotOk constructor.
     *
     * @param string|int|null $code
     * @param string|null $text
     * @param string|null $level
     * @param string|null $source
     */
    public function __construct($code = null, $text = null, $level = null, $source = null)
    {
        $this->code = $code;
        $this->text = $text;
        $this->level = $level;
        $this->source = $source;
    }
}
