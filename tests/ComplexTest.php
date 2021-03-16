<?php 
include 'Complex.php';
class ComplexTest extends \PHPUnit\Framework\TestCase
{

	public function creator()
	{
		return [
			'dig i'=>[[0,1],'i'],
			'dig 5+9i'=>[[5.5,9],'5.5+9i'],
			'dig 10,i'=>[[10,0.5],'10+0.5i'],
			'dig 0,5i'=>[[0,5],'5i'],
			'dig 0,-5i'=>[[0,-5],'-5i'],
			'dig -6,-5i'=>[[-6,-5],'-6-5i'],
			'dig -0'=>['-0','0'],
			'dig i'=>['i','i'],
			'dig 3.5'=>['3.5','3.5'],
			'dig1 3.5'=>[3.5,'3.5'],
			'dig -i'=>['-i','-i'],
			'dig 5-i'=>['5-i','5-i'],
			'dig -0-i'=>['-0-i','-i'],
			'dig -5i'=>['-5i','-5i'],
			'dig 6'=>['6','6'],
			'dig 0.6'=>['0.6+i','0.6+i'],
			'error '=>['qdqweqwe','0'],
			'dig -8.8i'=>['-8.8i','-8.8i']
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


	public function opersProvider()
	{
		return [// 5-6i
			['add','0','5-6i'],
			['add','i','5-5i'],
			['add','-5i','5-10i'],
			['sub','3.5','1.5-10i'],
			['mul',2,'3-20i'],
			['mul','1-2i','-37-26i'],
			['div',new Complex(4,0),'-9.25-6.5i'],
			['div',new Complex(-4,3),'2.5+7.68i'],
		];
	}

	public function testOperInit()
	{
		$c=new Complex('5-6i');
		$this->assertEquals($c,'5-6i');
		return $c;
	}

	/**
	 * @dataProvider opersProvider
	 * @depends testOperInit
	 */
	public function testQueueOpers($oper,$dig,$res,$c)
	{
		call_user_func([$c,$oper], $dig);
		$this->assertEquals($c,$res,'ошибка'.$c);
	}
}