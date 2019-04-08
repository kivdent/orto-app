<?php

/**
 *  описывает поведение сущьности user
 */

namespace common\interfaces;

/**
 *
 * @author kivdent
 */
interface UserInterface {

    public function inactivate();

    public function getRoles();

    public function getEmploye();

    public function activate();

    public function getStatus();
}
