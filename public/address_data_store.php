<?php
require_once 'filestore.php';


class AddressDataStore extends Filestore{


    function read_address_book()
    {
        return $this->read_csv();
    }

    function write_address_book($addresses_array) 
    {
        $this->write_csv($addresses_array);
    }

}

?>