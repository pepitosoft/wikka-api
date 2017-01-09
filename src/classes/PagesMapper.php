<?php
class PagesMapper extends Mapper
{
  public function getDef() {
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

  public function getPages() {
        $sql = "SELECT p.id, p.tag, p.title, p.time, p.body, p.owner, p.user, p.latest, p.note
            FROM ".$this->settings['db']['prefix']."pages p
            WHERE p.latest = 'Y' LIMIT 5";
      $stmt = $this->db->query($sql);
      $results = [];
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $row->body = base64_encode($row->body);
          $results[] = $row;
      }
      return $results;
  }

  public function getPagesAll($rows_number) {
      $sql = "SELECT p.id, p.tag, p.title, p.time, p.body, p.owner, p.user, p.latest, p.note
          FROM ".$this->settings['db']['prefix']."pages p";
      $stmt = $this->db->query($sql);
      //$pages = $result->fetch(PDO::FETCH_OBJ);
      $results = [];
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $row->body = base64_encode($row->body);
          $results[] = $row;
      }
      return $results;
  }

  /**
   * Get one pages by its ID
   *
   * @param int $ticket_id The ID of the ticket
   * @return TicketEntity  The ticket
   */
  public function getPageById($page_id) {
      $sql = "SELECT p.id, p.tag, p.title, p.time, p.body, p.owner, p.user, p.latest, p.note
          FROM ".$this->settings['db']['prefix']."pages p
          where p.id = :page_id";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(["page_id" => $page_id]);
      $results = $stmt->fetch(PDO::FETCH_OBJ);
      $results->body = base64_encode($results->body);
      return $results;
  }

    public function getPages123() {
        $sql = "SELECT p.id, p.tag, p.title, u.email
            from wikka_pages p
            join wikka_users u on (u.name = p.owner)";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new TicketEntity($row);
        }
        return $results;
    }

    public function save(TicketEntity $ticket) {
        $sql = "insert into tickets
            (title, description, component_id) values
            (:title, :description,
            (select id from components where component = :component))";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "title" => $ticket->getTitle(),
            "description" => $ticket->getDescription(),
            "component" => $ticket->getComponent(),
        ]);
        if(!$result) {
            throw new Exception("could not save record");
        }
    }
}
