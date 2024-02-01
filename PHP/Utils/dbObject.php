<?php
interface DBObject extends JsonSerializable
{
    public function db_serialize();
}
?>