<?php

namespace App\Contracts;

/**
 * STEP KE - 1.
 * ------------
 * Interface KampusRepository.
 *
 * Interface ini adalah untuk menentukan behavior suatu class.
 * Misalkan Jika Interface AnimalRepository, Definisikan "Makan", "Minum", "BuangAirKecil", etc.
 *
 * LANGKAH KE - 2.
 * --------------
 * Buat class untuk implement \App\Contracts\KampusRepository, contohnya :
 *
 * @see \App\Repositories\EloquentKampusRepository
 *
 * LANGKAH KE - 3.
 * ---------------
 * Buat class Singleton untuk keperluan Facade Laravel. contohnya :
 *
 * @see \App\VouchersApp
 *
 * LANGKAH KE - 4.
 * ---------------
 * Buat class ServiceProviders Laravel, contohnya :
 *
 * @see \App\Providers\VoucherServiceProvider::registerFacades()
 *
 * LANGKAH KE - 5.
 * ---------------
 * Buat class Laravel Facade, sesuai dengan ketentuan laravel, contohnya :
 *
 * @see \App\Facades\Vouchers
 *
 * @package App\Contracts
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
interface KampusRepository
{

}