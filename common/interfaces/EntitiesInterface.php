<?php

/*
 * Интерфейс сущностей программы
 */

namespace common\interfaces;

/**
 *
 * @author kivde
 */
interface EntitiesInterface {
    /**
     * Получение экземпляра по идентификатору
     * @param type $id
     */
public static function getById($id);
/**
 * 
 * получение списка 
 */
public static function getAll();
/**
 * сохранение
 */
public function save();
/**
 * удаление
 */
public function delete();
/**
 * получение идентификатора
 */
public function getId();

        
}
