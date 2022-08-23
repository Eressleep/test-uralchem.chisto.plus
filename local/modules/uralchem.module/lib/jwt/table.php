<?php

namespace Uralchem\Module\Jwt;


use Bitrix\Main\Entity;
use Bitrix\Main\Entity\DateField;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

class JwtTable extends Entity\DataManager
{
    public static function getTableName() : string
    {
        return 'b_user_jwt';
    }

    public static function getUfId(): string
    {
        return 'B_USER_JWT';
    }

    /**
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new Entity\IntegerField(
                'ID',
                [
                    'primary'      => true,
                    'autocomplete' => true,
                    'title'        => Loc::getMessage('URALCHEM_LOG_TABLE_ID'),
                ]
            ),
            new Entity\IntegerField(
                'USER_ID',
                [
                    'required' => true,
                    'title'    => Loc::getMessage('URALCHEM_LOG_TABLE_USER_ID'),
                ]
            ),
            new DateField(
                'PUBLISH_DATE',
                [
                    'required' => true,
                    'title'    => Loc::getMessage('URALCHEM_LOG_TABLE_PUBLISH_DATE'),
                ]
            ),
            new Entity\StringField(
                'JWT',
                [
                    'required' => true,
                    'title'    => Loc::getMessage('URALCHEM_LOG_TABLE_JWT'),
                ]
            ),

        ];
    }
}
