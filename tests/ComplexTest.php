<?php 
include 'Complex.php';
class ComplexTest extends \PHPUnit\Framework\TestCase
{

	public function creator()
	{
		return [
			'dig i'=>[[0,1],'i'],
			'dig 5+9i'=>[[5,9],'5+9i'],
			'dig 10,i'=>[[10,0],'10'],
			'dig 0,5i'=>[[0,5],'5i'],
			'dig 0,-5i'=>[[0,-5],'-5i'],
			'dig -0,-5i'=>[[-6,-5],'-6-5i'],
			'dig -0'=>['-0','0'],
			'dig i'=>['i','i'],
			'dig -i'=>['-i','-i'],
			'dig 5-i'=>['5-i','5-i'],
			'dig -0-i'=>['-0-i','-i'],
			'dig -5i'=>['-5i','-5i'],
			'dig 6'=>['6','6'],
			'dig 0.6'=>['0.6+i','5.6'],
			'error '=>['qdqweqwe','0'],
		];
	}


	/**
	 * @dataProvider creator
	 */
	public function testCreateObjs($v,$r)
	{
		$a=6;
		if (is_array($v))
			$a=new Complex($v[0],$v[1]);
		else 
			$a=new Complex($v);
		$this->assertEquals($a,$r,'ошибка '.$a );
		return rand();
	}

	
	public function testOpers()
	{
		$c=new Complex('5-6i');
		$c->add('0');
		$this->assertEquals($c,'5-6i');
		$c->add('i');
		$this->assertEquals($c,'5-5i');
		$c->add('-5i');
		$this->assertEquals($c,'5-10i');
		$c->sub('-3');
		$this->assertEquals($c,'8-10i');
		$c->mul('2');
		$this->assertEquals($c,'16-20i');
		$c->mul('1-2i');
		$this->assertEquals($c,'-24-52i');
		$c->div(4);
		$this->assertEquals($c,'-6-13i');
		$c->div('-4+3i');
		$this->assertEquals($c,'-0.6+2.8i');



		
		//$this->assertTrue(true);
		//$this->assertEmpty($c);

		//echo $c."\n";
		//$c->add($v);
		
	}
}