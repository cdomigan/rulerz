<?php

namespace spec\RulerZ\Parser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HoaParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RulerZ\Parser\HoaParser');
    }

    /**
     * @dataProvider validRules
     */
    function it_returns_an_ast_for_a_valid_rule($rule)
    {
        $this->parse($rule)->shouldHaveType('RulerZ\Model\Rule');
    }

    /**
     * @dataProvider invalidRules
     */
    function it_throws_an_exception_for_an_invalid_rule($rule)
    {
        $this->shouldThrow('Hoa\Compiler\Exception')->duringParse($rule);
    }

    public function validRules()
    {
        return [
            [ 'points > 30' ],
            [ 'some_point ∈ some_figure' ],
            [ 'some_point ∈ :some_figure' ],
            [ 'some_point ∈ ["some", "list", "of", "points"]' ],
            [ 'group(user) ∈ :allowed_groups' ],
            [ 'locked = false' ],
            [ 'admin = true' ],
            [ 'deleted_at = null' ],
            [ 'user.group = "members"' ],
            [ "user.group = 'members'" ],
            [ 'user.group in ["members", "admins"]' ],
            [ 'length(name) = 4' ],
            [ 'distance(lat1, long1, lat2, long2) < 50' ],
            [ 'name = :user_name' ],
            [ 'name = ?' ],
            [ 'name = ? and group = ?' ],
            [ 'name = ? and group = :group' ],
            [ 'points > 30 and group = "member"' ],
            [ '(points > 30 and group in ["member", "guest"]) or group = "admin"' ],
            [ 'not points > 30' ],
        ];
    }

    public function invalidRules()
    {
        return [
            [ '> 30' ],
            [ 'name[0] = "a"' ],
            [ 'name.foo() = "a"' ],
        ];
    }
}
