<?php


use Eslym\SqlBuilder\Dml\Helpers\func;
use Eslym\SqlBuilder\Dml\Helpers\sql;
use PHPUnit\Framework\TestCase;

class BuidlerTest extends TestCase
{
    function testJoin(){
        $query = sql::table('users')->as($u)
            ->join('user_profiles')->as($p)->on($p->user_id->_eql_($u->profile_id))
            ->join('roles')->as($r)->on($u->role_id->_eql_($r->id))
            ->select($u->all())
            ->where($p->status->_eql_('active')->_and_($r->name->_eql_('admin')));

        $this->assertEquals(
            "SELECT `users`.* FROM `users` INNER JOIN `user_profiles` AS `t1` ON `t1`.`user_id` = `users`.`profile_id` INNER JOIN `roles` ON `users`.`role_id` = `roles`.`id``t1`.`status` = ? AND (`roles`.`name` = ?)",
            $query->toSql()
        );

        $this->assertEquals(['active', 'admin'], $query->bindings());
    }
}