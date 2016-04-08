<?php
namespace App\Fractal;

use League\Fractal\Resource\Collection as CollectionFractal;
/**
* 
*/
class Collection extends CollectionFractal
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
    	$data = [];
        foreach ($this->data as $item) {
            
            $data[] = $this->transformer->transform($item);
        }

    	return [
    		'status' => 'success',
    		'data' => $data
    	];
    }
}

?>