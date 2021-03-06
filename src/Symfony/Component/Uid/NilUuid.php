<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Uid;

/**
 * @experimental in 5.1
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class NilUuid extends Uuid
{
    protected const TYPE = \UUID_TYPE_NULL;

    public function __construct()
    {
        $this->uid = '00000000-0000-0000-0000-000000000000';
    }
}
