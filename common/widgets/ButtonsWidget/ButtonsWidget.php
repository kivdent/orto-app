<?php

namespace common\widgets\ButtonsWidget;


use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

class ButtonsWidget extends \yii\base\Widget
{
    const ALIGNMENT_HORIZONTAL = 'btn-group';
    const ALIGNMENT_VERTICAL = 'btn-group-vertical';
    const ROLE_ALL = 'all';

    public $alignment = self::ALIGNMENT_HORIZONTAL;
    /**
     * @var array
     * [    'role_available'=>[],
     *      'text'=>'',
     *      'url'=>[]Url::to(),
     *      'options'=>[
     *                      'class'=>$this->buttons_class,
     *                      'title' => 'Создать рассрочку оплаты за ортодонтическое лечение',
     *                  'target' => '_blank'
     *                  ]
     * ]
     */
    public $buttons = [];
    public $buttons_class = 'btn btn-xs btn-info';

    public $doctorAndRegistratorRoles = [
        UserInterface::ROLE_RECORDER,
        UserInterface::ROLE_SENIOR_RECORDER,
        UserInterface::ROLE_THERAPIST,
        UserInterface::ROLE_ORTHOPEDIST,
        UserInterface::ROLE_ORTHODONTIST,
        UserInterface::ROLE_SURGEON
    ];
    public $registratorRoles = [
        UserInterface::ROLE_RECORDER,
        UserInterface::ROLE_SENIOR_RECORDER,
    ];
    public $doctorRoles = [
        UserInterface::ROLE_THERAPIST,
        UserInterface::ROLE_ORTHOPEDIST,
        UserInterface::ROLE_ORTHODONTIST,
        UserInterface::ROLE_SURGEON
    ];

    public function run()
    {

        $buttons = '';
//                    UserInterface::getVar($this->buttons);
        foreach ($this->buttons as $button) {

            if ($this->canUseButton($button['role_available'])) {

                $buttons .= Html::a(
                    Html::decode($button['text']),
                    $button['url'],
                    $button['options']
                );
            }
        }

        return $this->render('widget', [
                'buttons' => $buttons,
                'alignment' => $this->alignment,
            ]

        );
    }

    private function canUseButton(array $role_available)
    {
        return in_array(self::ROLE_ALL, $role_available)
            || in_array(UserInterface::getRoleNameCurrentUser(), $role_available);
    }
}