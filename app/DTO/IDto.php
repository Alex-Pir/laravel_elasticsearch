<?php
namespace App\DTO;

/**
 * Интерфейс предназначен для описания
 * необходимых методов в DTO-объектах
 */
interface IDto {
    public function toArray(): array;
}
