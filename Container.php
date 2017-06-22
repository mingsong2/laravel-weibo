<?php
class Container
{
    /**
     * @var array 用于保存一组function
     */
    protected $bindings = [];

    /**
     * @param $abstract 用作下标 $bindings[$abstract] 值为$concrete
     * @param null $concrete 用于保存生成的闭包函数
     * @param null $shared
     */
    public function bind($abstract,$concrete=null,$shared=null)
    {
        if(!$concrete instanceof Closure)  //Closure闭包函数的类 用于将闭包函数绑定到$this对象和类的作用域
        {
            $concrete = $this->getClosure($abstract,$concrete);
        }
        $this->bindings[$abstract]=compact('concrete','shared');
    }

    /**
     * @param $abstract
     * @param $concrete
     * @return Closure 返回一个闭包函数
     */
    protected function getClosure($abstract,$concrete)
    {
        return function ($c) use ($abstract,$concrete)
        {
            $method = ($abstract == $concrete) ? 'build' : 'make';
            return $c->method($concrete);
        };
    }

    public function make($abstract)
    {
        $concrete = $this->getContrete($abstract);
        if($this->isBuildable($concrete,$abstract)){
            $object = $this->build($concrete);
        }else{
            $object = $this->make($concrete);
        }
        return $object;
    }

    protected function isBuildable($concrete,$abstract){
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    public function build($concrete){
        if($concrete instanceof Closure){
            return $concrete($this);
        }
        $refector = new ReflectionClass($concrete);
        if(!$refector->isInstantiable()){
            echo $message = "Target[$concrete] is not instantiable.";
        }

        $constructor = $refector->getConstructor();

        if(is_null($constructor)){
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->getDependencies($dependencies);
        return $refector->newInstanceArgs($instances);
    }


    protected function getDependencies($parameters)
    {
        $dependencies=[];
        foreach($parameters as $parameter){
            $dependency=$parameter->getClass();
            if(is_null($dependency)){
                $dependencies[]=null;
            }else{
                $dependencies[]=$this->resolveClass($parameter);
            }
        }

        return (array)$dependencies;
    }

    protected function resolveClass(ReflectionParameter $parameter)
    {
        return $this->make($parameter->getClass()->name);
    }
}

class Traveller{

    protected $trafficTool;
    public function __construct(Visit $trafficTool)
    {
        $this->trafficTool = $trafficTool;
    }
    public function visitTibet(){
        $this->trafficTool->go();
    }
}

$app=new Container();
$app->bind("Visit","Train");
$app->bind("traveller","Traveller");
$tra=$app->make("traveller");
$tra->visitTibet();