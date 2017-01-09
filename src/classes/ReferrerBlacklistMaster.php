<?php
class ReferrerBlacklistMapper extends Mapper
{
  public function getUserDef() {
      if( $this->db->getAttribute(PDO::ATTR_DRIVER_NAME) == "sqlite" ){
        $sql = "PRAGMA table_info([".$this->settings['db']['prefix']."pages])";
      } else {
        $sql = "DESCRIBE ".$this->settings['db']['prefix']."pages";
      }
      $stmt = $this->db->query($sql);
      $results = [];
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $results[] = $row;
      }
      return $results;
  }

}
