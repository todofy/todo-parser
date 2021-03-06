<?php
$SECURE = true;
include __DIR__ .'/../parser.php';

/**
 * main test class
 */
class TCI_TEST extends PHPUnit_Framework_TestCase
{
	/**
     * Function to be run before every test*() functions.
     */
    public function setUp() {
    	date_default_timezone_set('UTC');
    }

    public function tearDown() {

    }	

    public function test_simple_1()
    {
    	$g = new parser("#todo: complete this on time \n this is very important");
    	$this->assertEquals($g->todo, "complete this on time this is very important");
    	$this->assertEquals($g->deadline, -1);
    	$this->assertEquals($g->deadline_text, -1);
    	$this->assertEquals($g->reminder, -1);
    	$this->assertEquals($g->reminder_text, -1);

    	$this->assertEquals(count($g->tags), 0);
    	$this->assertEquals(count($g->labels), 0);

    	$this->assertTrue(is_null($g->assignment));
    	$this->assertTrue(is_null($g->priority));
    }

    public function test_simple_2() {
    	$g = new parser(" TODO complete this on time, this is very important @deadline 2/12/2014 @reminder 11/7/15
    		@tags mebjas, abhinavdahiya, raj
    		@labels test, phpunit, amazing ness
    		@priority high
    		@assign mebjas");

    	$this->assertEquals($g->todo, "complete this on time, this is very important");
    	$this->assertEquals($g->deadline, 1392163200);
    	$this->assertEquals($g->deadline_text, "2/12/2014");

    	$this->assertEquals($g->reminder, 1446854400);
    	$this->assertEquals($g->reminder_text, "11/7/15");

    	$this->assertEquals(count($g->tags), 3);
    	$this->assertEquals(count($g->labels), 4);

    	$this->assertEquals(count(array_intersect(array('test', 'phpunit', 'amazing', 'ness'), $g->labels)), 4);
    	$this->assertEquals(count(array_intersect(array('mebjas', 'abhinavdahiya', 'raj'), $g->tags)), 3);


    	$this->assertEquals($g->priority, "high");
    	$this->assertEquals($g->assignment, "mebjas");
    }

    public function test_simple_3() {
    	$g = new parser("TOdO: complete this on time, this is very important");

    	$this->assertEquals("complete this on time, this is very important", $g->todo);
    }

    public function test_simple_4() {
    	$g = new parser(" @todo - Add the {animate = true} option and create the algo for that");

    	$this->assertEquals("Add the {animate = true} option and create the algo for that", $g->todo);
    }

	public function test_simple_5() {
		$g = new parser(" :TODO: optimization: test directly for !important and ! important");
		$this->assertEquals("optimization: test directly for !important and ! important", $g->todo);
	}
	
	public function test_simple_6() {
		$g = new parser(" textTODO: optimization: test directly for !important and ! important");
		$this->assertEquals("textTODO: optimization: test directly for !important and ! important", $g->todo);
	}
	
    public function test_deadline_1() {
    	$g = new parser("todo: complete this on time, this is very important @deadline 1 week @reminder 2 days");
    	$this->assertEquals("complete this on time, this is very important", $g->todo);	

    	$t = time() + 86400 * 7;
    	$this->assertTrue($g->deadline >= $t - 1000 && $g->deadline <= $t + 1000);

    	$t = time() + 86400 * 2;
    	$this->assertTrue($g->reminder >= $t - 1000 && $g->reminder <= $t + 1000);

    	$this->assertEquals($g->deadline_text, "1 week");
    	$this->assertEquals($g->reminder_text, "2 days");
    }

    public function test_no_todo_string() {
        $g = new parser("complete this by today #TODO ");
        $this->assertEquals('complete this by today #TODO', $g->todo);
        $this->assertTrue($g->_tsnf);
    }


    public function test_complex_1() {
    	$g = new parser(" TODO(ecoal95): Get a machine to test with mac and 45	
			 get android building:");
        $this->assertEquals("Get a machine to test with mac and 45 get android building:", $g->todo);
    	$this->assertEquals("ecoal95", $g->assignment);
    }

    public function test_complex_2() {
    	$g = new parser("this is amazing test @todo -  this is another type of message,  this indicates we have something to todo here  @deadline - 4823746827, @tags - kjshfkj, jhsagfj, hgsfjs");

    	$this->assertEquals("this is another type of message, this indicates we have something to todo here", $g->todo);
    }

    public function test_complex_3() {
    	$g = new parser(" #todo - test when just a todo is modiphied @assign: mebjas @deadline: 1 week @priority: high");

    	$this->assertEquals("test when just a todo is modiphied", $g->todo);
    }

    public function test_complex_4() {
    	$g = new parser(" #todo - adding a new todo to test auto following @labels - test, todoCI, development");

    	$this->assertEquals("adding a new todo to test auto following", $g->todo);
    }

    public function test_complex_5() {
    	$g = new parser(" - TODO_TEST - Adding a new line not related to todo");

    	$this->assertEquals("TEST - Adding a new line not related to todo", $g->todo);
    }

    public function test_complex_6() {
    	$g = new parser("^ @todo - make this structure memory efficient by  {modified todo text} a linked list in place of an array ^ format 2 ");

    	$this->assertEquals("make this structure memory efficient by {modified todo text} a linked list in place of an array ^ format 2", $g->todo);

    }

    public function test_complex_7() {
        $g = new parser(" TODO \" this is a whole new type of todo \" ");
        $this->assertEquals('" this is a whole new type of todo "', $g->todo);
    }

    public function test_comple_8() {
        $g = new parser(" FIXME(ecoal95): 'antialias' should be true by default but we do not support antialising so... We must change it when we do. See GLFeature.");
        $this->assertEquals("'antialias' should be true by default but we do not support antialising so... We must change it when we do. See GLFeature.", $g->todo);
        $this->assertEquals('ecoal95', $g->assignment);
    }

    public function test_comple_9() {
        $g = new parser(" FIXME(ecoal95): %^& We must change it when we do. See GLFeature.");
        $this->markTestSkipped("here we must ignore the initial symbols, get the text todos and assignment to ecoal95");

        $this->assertEquals("We must change it when we do. See GLFeature.", $g->todo);
        $this->assertEquals('ecoal95', $g->assignment);
    }

    public function test_comple_10() {
        $g = new parser("** @todo [words]  check regular expressions for special char replacements (stored specialchared in db) @label: google");

        $this->assertEquals("[words] check regular expressions for special char replacements (stored specialchared in db)", $g->todo);

        $this->assertEquals(count($g->labels), 1);
        $this->assertEquals($g->labels[0], 'google');

    }

    public function test_future_1() {
    	$g = new parser("if \$length > 128 throw exception #todo");

    	$this->markTestSkipped("the todo here should be: if \$length > 128 throw exception");
    }

    public function test_future_2() {
    	$g = new parser('Check if content before </body> is </script> #todo $this->markTestSkipped("todo, add appropriate test here");');

    	$this->markTestSkipped('here, the todo SHOULD be: $this->markTestSkipped("todo, add appropriate test here");');
    	$this->markTestSkipped('here, the todo COULD be: Check if content before </body> is </script> ');
    }

    public function test_fixme_1() {
        $g = new parser('FIXME(ecoal95): uncomment me when we have cross-system constants if GLFeature::is_supported @deadline 1 week @tags abhinavdahiya, mebjas, ashutosh11939');
        $this->assertEquals('uncomment me when we have cross-system constants if GLFeature::is_supported', $g->todo);
        $this->assertEquals('ecoal95', $g->assignment);

        $this->assertEquals(count($g->tags), 3);
        $this->assertEquals($g->tags[0], 'abhinavdahiya');
        $this->assertEquals($g->tags[1], 'mebjas');
        $this->assertEquals($g->tags[2], 'ashutosh11939');

        $this->assertEquals($g->deadline_text, '1 week');
    }
};