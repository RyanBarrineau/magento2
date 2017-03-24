<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Staging\Model\Update;

/**
 * Class IncludesList
 */
class IncludesList
{
    /**
     * @var IncludesInterface[]
     */
    protected $includes;

    /**
     * IncludesList constructor.
     *
     * @param IncludesInterface[] $includes
     */
    public function __construct(
        array $includes = []
    ) {
        $this->includes = $includes;
    }

    /**
     * Returns list of includes types
     *
     * @return IncludesInterface[]
     */
    public function getIncludesTypes()
    {
        return $this->includes;
    }
}
