<?php

namespace App\Domain\Certificates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CertificateType
 *
 * @property int $id Идентификатор типа сертификата
 * @property string $name Название типа сертификата
 * @property string $description Описание типа сертификата
 * @property float $price Стоимость типа сертификата
 */
class CertificateType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
