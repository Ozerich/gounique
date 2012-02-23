<?php

class ProvisionLevel extends ActiveRecord\Model
{
    static $table_name = "provision_levels";

    public function get_plain_text(){
        return $this->from." - ".$this->to." : ".$this->percent . "%";
    }
}

?>