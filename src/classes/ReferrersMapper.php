<?php
class ReferrersMapper extends Mapper
{
  public function getDef() {
      if( $this->db->getAttribute(PDO::ATTR_DRIVER_NAME) == "sqlite" ){
        $sql = "PRAGMA table_info([".$this->settings['db']['prefix']."referrers])";
      } else {
        $sql = "DESCRIBE ".$this->settings['db']['prefix']."referrers";
      }
      $stmt = $this->db->query($sql);
      $results = [];
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $results[] = $row;
      }
      return $results;
  }

}
