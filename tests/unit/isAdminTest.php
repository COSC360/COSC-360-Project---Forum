<?php
declare(strict_types = 1);

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class LogInTest extends TestCase{
    public function test_isAdmin(){
        require "isAdmin.php";
        require "database.php";

        $adminUsername = 'topAdmin2023';

        $this->assertTrue(isAdmin($adminUsername));
    }
}
?>