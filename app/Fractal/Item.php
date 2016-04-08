<?php
namespace App\Fractal;

use League\Fractal\Resource\Item as ItemFractal;
/**
* 
*/
class Item extends ItemFractal
{
	/**
     * Create a new resource instance.
     *
     * @param mixed           $data
     * @param callable|string $transformer
     * @param string          $resourceKey
     *
     * @return void
     */
    public function __construct($data = null, $transformer = null, $resourceKey = null)
    {
        parent::__construct($data, $transformer, $resourceKey);
    }


    public function getSuccess()
    {
    	$data = $this->transformer->transform($this->data);

    	return [
    		'status' => 'success',
    		'data' => $data
    	];
    }
}

?>