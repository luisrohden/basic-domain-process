<?php
namespace luisrohden\Model;
class Domain{
    private $response,$request; 
    public function __construct(string $defaultControlerName='System', string $defaultMethodName='Index'){
		$this->response = [
			'controllerName' => $defaultControlerName,
			'methodName' => $defaultMethodName,
		];
        $this->request = explode('/',$_SERVER['REQUEST_URI']);
	}
    public function getArguments(): array {
		$index=3;
		$total = count($this->request);
		$args = [];
		if($total < $index) return $args;	
		
        for($i=$index;$i<$total+1;$i++){
            if(isset($this->request[$i+1])){
                $name =  $this->request[$i] ?: '';
                $value = $this->request[$i+1] ?: '';
            }
            elseif(isset($this->request[$i])){
                $name =  'element';
                $value = $this->request[$i];
            }
            $args[$name]=$value;
            $i++;
        }
		return $args;
	}
    public function getResponse(): array{
        $this->response['controllerName']=$this->validateRequest(1,'controllerName');
		$this->response['methodName']=$this->validateRequest(2,'methodName');
		$this->response['request_arguments']=$this->getArguments();
        return  $this->response;  
    }
    private function validateRequest(int $index = 0 ,string $default): string{
		if(isset($this->request[$index]) && $this->request[$index]!=''){
			return $this->request[$index];
		}
		return $this->response[$default];
	}
}
