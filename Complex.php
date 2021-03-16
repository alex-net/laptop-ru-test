<?php 

class Complex {

	/**
	 * действительна часть комплексного числа
	 * @var [type]
	 */
	private $re=0;

	/**
	 *  мнимая часть комплексного числа.. 
	 * @var [type]
	 */
	private $im=0;

	public function __construct (...$var)
	{
		if(!empty($var[0]) && is_string($var[0]) && preg_match('#(-?\d*\.?\d*)([+-]?\d*\.?\d*i)?#i',$var[0],$els)){
			array_shift($els);
			if (count($els)==2 && ($els[0]=='-' || !in_array($els[1][0],['+','-']) ))
				$els=[implode('',$els)];
			if (count($els)==1 )
				if (strpos($els[0], 'i')!==false)
					array_unshift($els, '0');
				else
					$els[]='0';
			if (strpos($els[1], 'i')!==false){
				$replacer='1';
				if(preg_match('#\d#', $els[1]))
					$replacer='';
				$els[1]=str_replace('i', $replacer, $els[1]);
			}
			
			//print_r($els);
			$var=array_map('intval', $els);
			
		}


		// переданы два числа .. 
		if (count($var)==2){
			$this->re=intval($var[0]);
			$this->im=intval($var[1]);
		}

	}
	

	public function __toString()
	{
		$str='';
		if ($this->re)
			$str=sprintf('%g',$this->re);
		if ($this->im){
			$fmt='%gi';
			if ($str)
				$fmt='%+gi';
			$str2=sprintf($fmt,$this->im);
			if (abs($this->im)==1)
				$str2=str_replace('1','', $str2);
			$str.=$str2;
		}
		$str=$str?$str:'0';
		return $str;
	}


	/**
	 * вернуть действительную часть
	 * @return int [description]
	 */
	public function getRe():int
	{
		return $this->re;
	}

	/**
	 * вернуть мнимую часть .. 
	 * @return int [description]
	 */
	public function getIm():int
	{
		return $this->im;
	}




	/**
	 * сложение ...
	 * @param Complex $c [description]
	 */
	public function add($c)
	{
		if ($c instanceof Complex){
			$this->re+=$c->getRe();
			$this->im+=$c->getIm();
			return $this;
		}
		switch(gettype($c)){
			case 'integer':
				$this->re+=$c;
			break;
			case 'string':
				$tmp=new static($c);
				if ($tmp)
					$this->add($tmp);
		}
		return $this;
	}


	/**
	 * вычетание
	 * @param Complex $c [description]
	 */
	public function sub($c)
	{
		if ($c instanceof Complex){
			$this->re-=$c->getRe();
			$this->im-=$c->getIm();
			return $this;
		}
		switch(gettype($c)){
			case 'integer':
				$this->re-=$c;
			break;
			case 'string':
				$tmp=new static($c);
				if ($tmp)
					$this->sub($tmp);
		}
		return $this;
	}

	/**
	 * умножение 
	 * @return [type] [description]
	 */
	public function mul($c)
	{
		if ($c instanceof Complex){
			$re=$c->getRe();
			$im=$c->getIm();
			$oldRe=$this->re;
			$this->re=$this->re*$re-$this->im*$im;
			$this->im=$oldRe*$im+$this->im*$re;
			return $this;
		}
		switch(gettype($c)){
			case 'integer':
				$this->re*=$c;
				$this->im*=$c;
			break;
			case 'string':
				$tmp=new static($c);
				if ($tmp)
					$this->mul($tmp);
		}

		return $this;
	}

	public function div($c)
	{
		if ($c instanceof Complex){
			$znam=new Complex($c->getRe(),-$c->getIm());
			$c->mul($znam);
			$this->mul($znam);
			$this->div($c->getRe());
			return $this;
		}
		print_r(gettype($c));
		switch(gettype($c)){
			case 'integer':
				if (empty($c)){
					throw new \Exception("Dividion by zerro", 1);
					
					break;
				}
				$this->re/=$c;
				$this->im/=$c;
			break;
			case 'string':
				$tmp=new static($c);
				if ($tmp)
					$this->div($tmp);
		}

	}

}