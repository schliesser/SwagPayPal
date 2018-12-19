<?php declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPayPal\Setting;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class SwagPayPalSettingGeneralCollection extends EntityCollection
{
    /**
     * @var SwagPayPalSettingGeneralEntity[]
     */
    protected $elements = [];

    public function first(): SwagPayPalSettingGeneralEntity
    {
        return parent::first();
    }

    protected function getExpectedClass(): string
    {
        return SwagPayPalSettingGeneralEntity::class;
    }
}
