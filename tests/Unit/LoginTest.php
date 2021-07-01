<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\HTTPRequest;

class LoginTest extends TestCase
{
    /**
     * Probar si se esta obteniendo informacion del programa de usuario
     *
     * @return void
     */
    public function test_getInfoProgram()
    {
        $cohorte = 20201;
        $codigo = 20171154652;

        $respuesta = HTTPRequest::getStudentProgram($cohorte,$codigo);

        $this->assertEquals($respuesta,"76 - ADMINISTRACION DE EMPRESAS (NOCTURNA) - GARZON");
    }
}
