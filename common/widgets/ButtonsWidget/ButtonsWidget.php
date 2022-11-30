<?php

namespace common\widgets\ButtonsWidget;


use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

class ButtonsWidget extends \yii\base\Widget
{
    const ALIGNMENT_HORIZONTAL = 'btn-group';
    const ALIGNMENT_VERTICAL = 'btn-group-vertical';
    const ROLE_ALL = 'all';

    const STYLE_DROPDOWN = 'button dropdown';
    const STYLE_GROUP = 'button group';


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
    /**
     * @var mixed
     */
    public $style = self::STYLE_GROUP;
    public $label ='Действия';


    public function run()
    {
        $buttons = '';
        //UserInterface::getVar($this->buttons);
        foreach ($this->buttons as $button) {
            if ($this->canUseButton($button['role_available'])) {
                if ($this->style == self::STYLE_GROUP) {
                    $buttons .= Html::a(
                        Html::decode($button['text']),
                        $button['url'],
                        $button['options']
                    );
                } else {
                    $buttons .= '<li>'.Html::a(
                        Html::decode($button['text']),
                        $button['url'],
                        ['target'=>'_blank']
                    ).'</li>';
                }
            }
        }

        return $this->render('widget', [
                'buttons' => $buttons,
                'alignment' => $this->alignment,
                'style' => $this->style,
                'label' => $this->label,
                'buttons_class' => $this->buttons_class,
            ]

        );
    }

    private function canUseButton(array $role_available)
    {
        return in_array(self::ROLE_ALL, $role_available)
            || in_array(UserInterface::getRoleNameCurrentUser(), $role_available);
    }
}