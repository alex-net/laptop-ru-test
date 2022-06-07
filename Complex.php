<?php 
/**
 * класс для работы с комплексными числами . 
 */
class Complex 
{

    /**
     * действительна часть комплексного числа
     * @var [type]
     */
    private $re = 0;

    /**
     *  мнимая часть комплексного числа.. 
     * @var [type]
     */
    private $im = 0;

    public function __construct (...$var)
    {
        if(!empty($var[0]) && is_string($var[0]) && preg_match('#(-?\d*\.?\d*)([+-]?\d*\.?\d*i)?#i', $var[0], $els)) {
            array_shift($els);
            // мнимая часть может располздтись на два элемента если  не задана реальная составляющая ..
            if (count($els) == 2 && $els[1] == 'i') {
                $els = [0, implode('', $els)];
            }
            // есть мнимая составляющая .. и там нет цифр = надо заменить i на единицу .. 
            if (!empty($els[1]) && !preg_match('#\d#', $els[1])) {
                $els[1] = str_replace('i', '1', $els[1]);
            }

            $els = array_pad($els, 2, 0);
            $var = array_map('floatval', $els);         
        }

        $var = array_pad($var, 2, 0);
        
        $this->re = floatval($var[0]);
        $this->im = floatval($var[1]);
    }
    
    /**
     * Печать числа .
     * @return string [description]
     */
    public function __toString()
    {
        $str = '';
        if ($this->re) {
            $str = sprintf('%g', round($this->re, 2));
        }
        if ($this->im) {
            $fmt = '%gi';
            if ($str) {
                $fmt = '%+gi';
            }
            $str2 = sprintf($fmt, round($this->im, 2));
            if (abs($this->im) == 1) { 
                $str2 = str_replace('1', '', $str2);
            }
            $str .= $str2;
        }
        $str = $str ? $str : '0';
        return $str;
    }


    /**
     * вернуть действительную часть
     * @return int Действительная составляющая комплексного числа
     */
    public function getRe(): float 
    {
        return $this->re;
    }

    /**
     * вернуть мнимую часть .. 
     * @return int Мнимая составляющая комплексного числа 
     */
    public function getIm(): float
    {
        return $this->im;
    }


    /**
     * сложение ...
     * @param Complex|string|int $c Второе слогаемое
     */
    public function add($c)
    {
        if ($c instanceof Complex) {
            $this->re += $c->getRe();
            $this->im += $c->getIm();
            return $this;
        }
        $tmp = new static($c);
        if ($tmp) {
            $this->add($tmp);
        }
        return $this;
    }


    /**
     * вычетание
     * @param Complex $c вычитаемое
     */
    public function sub($c): Complex
    {
        if ($c instanceof Complex) {
            $this->re -= $c->getRe();
            $this->im -= $c->getIm();
            return $this;
        }

        $tmp = new static($c);
        $this->sub($tmp);
        return $this;
    }

    /**
     * умножение 
     * @param string|int|Complex  $c Второй множитель
     * @return [type] [description]
     */
    public function mul($c)
    {
        if ($c instanceof Complex) {
            $re = $c->getRe();
            $im = $c->getIm();
            $oldRe = $this->re;
            $this->re = $this->re * $re - $this->im * $im;
            $this->im = $oldRe * $im + $this->im * $re;
            return $this;
        }
        $tmp=new static($c);
        $this->mul($tmp);

        return $this;
    }

    /**
     * деление  
     * @param  Complex|string|int $c делитель
     * @return Complex
     */
    public function div($c)
    {
        if ($c instanceof Complex) {
            $re = $c->getRe();
            $im = $c->getIm();
            if($im) {
                $znam = new Complex($re, -$im);
                $c->mul($znam);
                $this->mul($znam);
                $this->div($re ** 2 - $im ** 2);
            } else {
                $this->re /= $re;
                $this->im /= $re;
            }

            return $this;
        }

        $tmp = new static($c);      
        $this->div($tmp);
        return  $this;
    }
}