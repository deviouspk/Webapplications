<?php
require_once('../libs/AutoLoader.php');

class ObjectsData extends Data
{


    public function getAllObjects(){
        $cursor = $this->find(Collection::OBJECT_DEFINITIONS, null);
        return json_encode($cursor->toArray());
    }
}
